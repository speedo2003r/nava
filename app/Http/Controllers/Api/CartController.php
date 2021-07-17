<?php

namespace App\Http\Controllers\Api;

use App\Entities\CarType;
use App\Entities\Coupon;
use App\Entities\Item;
use App\Entities\Order;
use App\Entities\OrderProduct;
use App\Entities\OrderService;
use App\Entities\UserAddress;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Credits\MethodResource;
use App\Http\Resources\Orders\CartDetailResource;
use App\Http\Resources\Orders\CartResource;
use App\Http\Resources\Orders\OrderProductResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\Orders\SingleCartResource;
use App\Repositories\CategoryRepository;
use App\Repositories\FeatureRepository;
use App\Repositories\GroupRepository;
use App\Repositories\ItemRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    use ResponseTrait;

    public $orderRepo, $userRepo, $categoryRepo, $service, $orderService;

    public function __construct(OrderServiceRepository $orderService, ServiceRepository $service, OrderRepository $order, UserRepository $user, CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->orderRepo = $order;
        $this->orderService = $orderService;
        $this->service = $service;
        $this->categoryRepo = $category;
    }

    public function AddToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $user = auth()->user();
        $service = $this->service->find($request['service_id']);
        $provider = $service->user;
        $orders = $this->orderRepo->findWhere(['user_id' => $user['id']])->where('status','=','pending');
        if (count($orders) == 0) {
            $order = $this->storeOrder($request->all());
        } else {
            foreach ($orders as $data) {
                if (($data['provider_id'] != $provider['id'])) {
                    $order = $this->storeOrder(array_filter($request->all()));
                } else {
                    $orderService = OrderService::where('order_id', $data['id'])->where('service_id', $service['id'])->first();
                    if ($orderService != null) {
                        $msg = app()->getLocale() == 'ar' ? 'تم اضافة هذه الخدمه من قبل' : 'This service has been added by';
                        return $this->ApiResponse('fail', $msg);
                    }
                    $this->updateOrder($data, array_filter($request->all()));
                    $order = $this->orderRepo->find($data['id']);
                }
            }
        }
        $price = $order->_price();
        $msg = app()->getLocale() == 'ar' ? 'تم الاضافه الي السله بنجاح' : 'successfully ad to cart';
        return $this->ApiResponse('success',$msg,[
            'price' => $price,
            'order_id' => $order['id'],
        ]);
    }

    public function Cart(LangRequest $request)
    {
        $user = auth()->user();
        $user_id = $user['id'];
        $orders = $this->orderRepo->whereHas('provider', function ($query) {
            $query->exist();
        })->where(['user_id' => $user_id])->where('status','=','pending')->get();
        return $this->successResponse(SingleCartResource::collection($orders));
    }

    public function singleCart(LangRequest $request)
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
        $service = $this->service->find($request['service_id']);
        $provider = $service->user;
        $user = auth()->user();
        $user_id = $user['id'];
        $order = $this->orderRepo->create([
            'total_items' => 1,
            'provider_id' => $provider['id'],
            'user_id' => $user_id,
            'category_id' => $provider['category_id'],
            'subcategory_id' => $service['sub_category_id'],
            'vat_per' => settings('tax'),
            'vat_amount' => ($service['price'] * settings('tax')) / 100,
            'final_total' => $service['price'],
        ]);
        $this->orderProductStore($order, $request);
        return $order;
    }

    private function updateOrder($data, $request)
    {
        $service = $this->service->find($request['service_id']);
        $tax = ($service['price'] * settings('tax')) / 100;
        $this->orderRepo->update([
            'total_items' => $data['total_items'] + 1,
            'vat_amount' => $data['vat_amount'] + $tax,
            'final_total' => $data['final_total'] + $service['price'],
        ], $data['id']);
        $orderService = OrderService::where('order_id', $data['id'])->where('service_id', $service['id'])->first();

        if ($orderService == null) {
            $this->orderProductStore($data, $request);
        }
    }

    public function orderProductStore($data, $request)
    {
        $service = $this->service->find($request['service_id']);
        $this->orderService->create([
            'order_id' => $data['id'],
            'service_id' => $service['id'],
            'price' => $service['price'],
        ]);
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
