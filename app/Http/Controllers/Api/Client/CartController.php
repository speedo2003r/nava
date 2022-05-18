<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\CartDetailResource;
use App\Http\Resources\Orders\CartResource;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
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
