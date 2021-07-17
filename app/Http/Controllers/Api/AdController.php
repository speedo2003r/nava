<?php

namespace App\Http\Controllers\Api;

use App\Entities\Ad;
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
use App\Http\Resources\services\AdResource;
use App\Http\Resources\services\SingleAdResource;
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

class AdController extends Controller
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

    public function singleAd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id' => 'required|exists:ads,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $ad = Ad::find($request['ad_id']);
        $ads = Ad::where('id','!=',$request['ad_id'])->exist()->orderByRaw('RAND()')->take(3)->get();
        return $this->successResponse([
            'ad' => SingleAdResource::make($ad),
            'semi_ads' => AdResource::collection($ads),
        ]);
    }

}
