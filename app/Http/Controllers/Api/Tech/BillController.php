<?php

namespace App\Http\Controllers\Api\Tech;

use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Api\AddBillNotes;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
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
    public function addBillNotes(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'notes' => 'required|string',
            'price' => 'required|max:8',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $order->bills()->create([
            'text' => $request['notes'],
            'price' => $request['price'],
            'vat_per' => settings('tax') ?? 0,
            'vat_amount' => settings('tax') > 0 ? ($request['price'] / (settings('tax') ?? 0)) : 0,
            'type' => 'service',
            'status' => 0,
            'payment_method' => 'cod',
        ]);
        $user = $order->user;
        $user->notify(new AddBillNotes($order));

        $admins = User::where('user_type',UserType::ADMIN)->where('notify',1)->get();
        $job = (new \App\Jobs\TechAddBillNotes($admins,$order));
        dispatch($job);
        return $this->successResponse();
    }

}
