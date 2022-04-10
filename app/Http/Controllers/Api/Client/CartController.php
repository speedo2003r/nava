<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\CarType;
use App\Entities\Category;
use App\Entities\Coupon;
use App\Entities\Item;
use App\Entities\Order;
use App\Entities\OrderService;
use App\Entities\Region;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Orders\CartDetailResource;
use App\Http\Resources\Orders\CartResource;
use App\Http\Resources\Orders\OrderProductResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\Orders\SingleCartResource;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    use ResponseTrait;
    use UploadTrait;

    public $orderRepo, $city, $userRepo, $categoryRepo, $service, $orderService;

    public function __construct(CityRepository $city,OrderServiceRepository $orderService, ServiceRepository $service, OrderRepository $order, UserRepository $user, CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->orderRepo = $order;
        $this->orderService = $orderService;
        $this->service = $service;
        $this->city = $city;
        $this->categoryRepo = $category;
    }


    public function Cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $user_id = auth()->id();
        if($user_id != null){
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',$user_id)->where('live',0)->first();
        }else{
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',null)->where('live',0)->first();
        }
        return $this->successResponse($order ? CartResource::make($order) : (object) []);
    }

    public function deleteCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'sub_category_id' => 'required|exists:categories,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $user_id = auth()->id();
        $order = $this->orderRepo->where('id',$request['order_id'])->where('user_id',$user_id)->first();
        if(!$order){
            return $this->ApiResponse('fail', 'order undefined');
        }
        $orderServices = $order->orderServices()->where('order_services.category_id',$request['sub_category_id'])->get();
        foreach ($orderServices as $orderService){
            $orderService->delete();
        }
        $order->update([
            'vat_amount' => ($order->price() * $order['vat_per'] ?? 0) / 100,
            'final_total' => $order->price(),
        ]);
        return $this->successResponse(['total'=>$order->_price(),'tax'=>$order['vat_amount']]);
    }

    public function addDateAndAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'date' => 'required|date|after:'.Carbon::yesterday()->format('Y-m-d'),
            'time' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required|string|max:250',
            'region_id' => 'required|exists:regions,id,deleted_at,NULL',
//            'floor' => 'nullable|string|max:250',
//            'residence' => 'nullable|string|max:250',
//            'street' => 'required|string|max:250',
            'address_notes' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        if(Carbon::now()->format('Y-m-d H:i:s') > Carbon::parse($request['date'])->format('Y-m-d').' '.Carbon::parse($request['time'])->format('H:i:s')){
            return $this->ApiResponse('fail', trans('api.timemustbe'));
        }
        $order = $this->orderRepo->find($request['order_id']);

        $mini_order_charge = settings('mini_order_charge');
        $increase = 0;
        $increase_tax = 0;
        $tax = $order['vat_amount'];
        if($order['increased_price'] > 0 && $order['final_total'] > $mini_order_charge){
            $increase = ($order['final_total'] < $mini_order_charge) ? $mini_order_charge - $order['final_total'] : 0;
            $increase_tax = ($order['final_total'] < $mini_order_charge) ? (($increase * $order['vat_per']) / 100) : 0;
        }
        $this->orderRepo->update([
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'time' => Carbon::parse($request['time'])->format('H:i:s'),
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'map_desc' => $request['address'],
            'region_id' => $request['region_id'],
            'increased_price' => $increase,
            'increase_tax' => $increase_tax,
            'vat_amount' => $tax,
//            'floor' => $request['floor'],
//            'residence' => $request['residence'],
//            'street' => $request['street'],
            'address_notes' => $request['address_notes'],
        ],$order['id']);
        return $this->successResponse();
    }
    public function addCoupon(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'coupon'              => ['required',Rule::exists('coupons','code')],
            'order_id'              => ['required',Rule::exists('orders','id')],
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $order = $this->orderRepo->find($request['order_id']);
        $arrProducts = $order->orderServices()->pluck('service_id')->toArray();
        $coupon = Coupon::where('code',$request['coupon'])->first();
        $couponValue = $coupon->couponValue($order['final_total'],$order['provider_id'],$arrProducts);
        if($order->coupon_id == null && $coupon['count'] > 0 && $coupon['end_date'] >= Carbon::now()->format('Y-m-d') && $coupon['start_date'] <= Carbon::now()->format('Y-m-d')){
            $total = (string) round($order->_price() ,2);
            if($coupon['kind'] == 'fixed' && ((integer) $coupon['value'] >=  (integer) $total)){
                return $this->ApiResponse('fail',app()->getLocale() == 'ar'? 'السعر أقل من قيمة الخصم لايمكن اتمام الخصم' : 'The price is less than the discount value, the discount cannot be completed');
            }
            $this->orderRepo->update([
                'coupon_id' => $coupon['id'],
                'coupon_num' => $coupon['code'],
                'coupon_amount' => $couponValue,
            ],$order['id']);
            $coupon->count = $coupon->count - 1;
            $coupon->save();
            $order = $this->orderRepo->find($request['order_id']);
            $total = (string) round($order->_price() ,2);
            return $this->successResponse(['total'=> $total,'value'=>$couponValue]);
        }else{
            return $this->ApiResponse('fail',trans('api.coupon_expired'));
        }
    }
    public function addNotesAndImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'notes' => 'nullable|string|max:2000',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png,svg|max:500000',
            'audio' => 'sometimes|max:500000',
            'video' => 'sometimes|max:500000',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->notes = $request['notes'];
        $order->save();
        if($request->has('image') && $request['image'] != null){
            if($order->files()->where('media_type','image')->count() > 0){
                foreach ($order->files()->where('media_type','image')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'image',
                'image' => $this->uploadFile($request['image'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        if($request->has('audio') && $request['audio'] != null){
            if($order->files()->where('media_type','audio')->count() > 0){
                foreach ($order->files()->where('media_type','audio')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'audio',
                'image' => $this->uploadFile($request['audio'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        if($request->has('video') && $request['video'] != null){
            if($order->files()->where('media_type','video')->count() > 0){
                foreach ($order->files()->where('media_type','video')->get() as $file){
                    $file->delete();
                }
            }
            $order->files()->create([
                'media_type' => 'video',
                'image' => $this->uploadFile($request['video'],'orders'),
                'image_id' => $request['order_id'],
                'image_type' => Order::class,
            ]);
        }
        return $this->successResponse();
    }

    public function cartDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        return $this->successResponse(CartDetailResource::make($order));
    }
    public function singleCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        return $this->successResponse(CartResource::make($order));
    }

    private function storeOrder($request)
    {
        $user_id = auth()->check() ? auth()->id() : null;
        if(isset($request['service_id']) && $request['service_id'] > 0){
            $service = $this->service->find($request['service_id']);
            $category = Category::find($request['category_id']);
            $order = $this->orderRepo->create([
                'uuid' => $request['uuid'],
                'total_services' => 1,
                'city_id' => $request['city_id'],
                'user_id' => $user_id,
                'category_id' => $category['parent_id'],
                'vat_per' => settings('tax') ?? 0,
                'vat_amount' => ($service['price'] * settings('tax') ?? 0) / 100,
                'final_total' => $service['price'],
            ]);
        }else{
            $category = Category::find($request['category_id']);
            $order = $this->orderRepo->create([
                'uuid' => $request['uuid'],
                'total_services' => 1,
                'city_id' => $request['city_id'],
                'user_id' => $user_id,
                'category_id' => $category['parent_id'],
                'vat_per' => settings('tax') ?? 0,
                'vat_amount' => (settings('preview_value') * settings('tax') ?? 0) / 100,
                'final_total' => settings('preview_value') ?? 0,
            ]);
        }

        $this->orderProductStore($order, $request);
        return $order;
    }

    private function updateOrder($data, $request)
    {
        if(isset($request['service_id']) && $request['service_id'] > 0) {
            $orderService = OrderService::where('order_id', $data['id'])->where('service_id', $request['service_id'])->first();
            if ($request['counter'] == 'up') {
                $service = $this->service->find($request['service_id']);
                $tax = ($service['price'] * settings('tax')) / 100;
                $this->orderRepo->update([
                    'total_services' => $data['total_services'] + 1,
                    'vat_amount' => $data['vat_amount'] + $tax,
                    'final_total' => $data['final_total'] + $service['price'],
                ], $data['id']);
                if ($orderService == null) {
                    $this->orderProductStore($data, $request);
                } else {
                    $orderService->count = $orderService->count + 1;
                    $orderService->save();
                }
            } else {
                $serviceData = $orderService;
                if ($orderService == null) {
                    $serviceData = $this->service->find($request['service_id']);
                    $tax = ($serviceData['price'] * settings('tax') ?? 0) / 100;
                } else {
                    $tax = $orderService['tax'];
                    if ($orderService['count'] == 1) {
                        $orderService->forceDelete();
                    }
                    $orderService->count = $orderService->count - 1;
                    $orderService->save();
                }
                $this->orderRepo->update([
                    'total_services' => $data['total_services'] - 1,
                    'vat_amount' => $data['vat_amount'] - $tax,
                    'final_total' => $data['final_total'] - $serviceData['price'],
                ], $data['id']);
            }
        }else{
            if(!$data->orderServices()->where('category_id',$request['category_id'])->where('preview_request',1)->exists()){
                $this->orderRepo->update([
                    'total_services' => $data['total_services'] + 1,
                    'vat_amount' => $data['vat_amount'] + ((settings('preview_value') ?? 0) * settings('tax') ?? 0) / 100,
                    'final_total' => $data['final_total'] + settings('preview_value') ?? 0,
                ], $data['id']);
                $this->orderProductStore($data, $request);
            }else{
                $dataService = $data->orderServices()->where('category_id',$request['category_id'])->where('preview_request',1)->first();
                $tax = $dataService['tax'];
                $price = $dataService['price'];
                $this->orderRepo->update([
                    'total_services' => $data['total_services'] - 1,
                    'vat_amount' => $data['vat_amount'] - $tax,
                    'final_total' => $data['final_total'] - $price,
                ], $data['id']);
                $dataService->forceDelete();
            }
        }

    }

    public function orderProductStore($data, $request)
    {
        if(isset($request['service_id']) && $request['service_id'] > 0){
            $service = $this->service->find($request['service_id']);
            $this->orderService->create([
                'title' => $service['title'],
                'type' => $service['type'],
                'status' => 1,
                'order_id' => $data['id'],
                'category_id' => $request['category_id'],
                'service_id' => $service['id'],
                'price' => $service['price'],
                'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
            ]);
        }else{
            $this->orderService->create([
                'title' => [
                    'ar' => 'طلب معاينه',
                    'en' => 'Request a preview',
                ],
                'type' => 'fixed',
                'status' => 1,
                'order_id' => $data['id'],
                'category_id' => $request['category_id'],
                'preview_request' => 1,
                'price' => settings('preview_value') ?? 0,
                'tax' => (settings('preview_value') * settings('tax') ?? 0) / 100,
            ]);
        }

    }

    public function deleteCartOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', Rule::exists('orders', 'id')],
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());
        $user_id = auth()->id();
        $this->orderRepo->delete($request['order_id']);
        $orders = $this->orderRepo->whereHas('provider', function ($query) {
            $query->exist();
        })->where(['user_id' => $user_id])->get();
        return $this->successResponse(['emptyCart' => count($orders) > 0 ? false : true]);
    }

}
