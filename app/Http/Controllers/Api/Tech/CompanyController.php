<?php

namespace App\Http\Controllers\Api\Tech;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\TechnicalResource;
use App\Models\User;
use App\Notifications\Api\AssignDelegate;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    use ResponseTrait;
    use NotifyTrait;

    public $orderRepo, $userRepo, $categoryRepo, $service, $orderService;

    public function __construct(OrderServiceRepository $orderService, ServiceRepository $service, OrderRepository $order, UserRepository $user, CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->orderRepo = $order;
        $this->orderService = $orderService;
        $this->service = $service;
        $this->categoryRepo = $category;
    }
    public function technicals(Request $request)
    {
        $user = auth()->user();
        $technicals = $user->technicians()->where('notify',1)->exist()->get();
        return $this->successResponse(TechnicalResource::collection($technicals));
    }
    public function orderTransfer(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id'   => 'required|exists:orders,id,deleted_at,NULL',
            'technical_id'   => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $technical = User::find($request['technical_id']);
        $order = $this->orderRepo->find($request['order_id']);
        $this->orderRepo->update([
            'technician_id' => $technical['id'],
            'status' => OrderStatus::ACCEPTED,
        ],$order['id']);
        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::ACCEPTED);
        $technical->notify(new AssignDelegate($order));

        $order->user->notify(new \App\Notifications\Api\AcceptOrder($order));
        creatPrivateRoom($technical['id'],$order['user_id'],$order['id']);
        return $this->successResponse();
    }

}
