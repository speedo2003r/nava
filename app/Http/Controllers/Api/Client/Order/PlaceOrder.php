<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Jobs\SendToDelegate;
use App\Models\User;
use App\Notifications\Api\NewOrder;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceOrder extends Controller
{
    use ResponseTrait;

    public function __construct(protected OrderRepository $orderRepo)
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'pay_type' => 'required|in:cash,wallet,visa,mada,apple',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        if($order->region == null){
            $msg = app()->getLocale() == 'ar' ? 'من فضلك أضف عنوان أولا للطلب' : 'Please add a title first to order';
            return $this->ApiResponse('fail', $msg);
        }
        $live = 1;
        $mini_order_charge = settings('mini_order_charge');
        if($order['final_total'] < $mini_order_charge){
            $mini_order_charge = settings('mini_order_charge');
        }else{
            $mini_order_charge = 0;
        }
        $this->orderRepo->update([
            'live' => $live,
            'pay_type' => $request['pay_type'],
            'status' => OrderStatus::CREATED,
            'created_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'final_total' => $order['final_total'],
            'increased_price' => ($order['final_total'] < $mini_order_charge) ? $mini_order_charge - $order['final_total'] : 0,
            'increase_tax' => ($order['final_total'] < $mini_order_charge) ? (($mini_order_charge - $order['final_total']) * $order['vat_per']) / 100 : 0,
        ],$order['id']);
        $this->orderRepo->addStatusTimeLine($order['id'],OrderStatus::CREATED);
        $branch = $order->region->branches()->first();
        if($branch){
            $on = now()->addMinutes((int) $branch['assign_deadline'] ?? 0);
            $users = User::where('user_type','technician')->where('notify',1)->exist()->whereHas('branches',function ($query) use ($branch){
                $query->where('users_branches.branch_id',$branch['id']);
            })->get();
            foreach($users as $user) {
                $job = new SendToDelegate($order,$user);
                if($branch['assign_deadline'] > 0){
                    dispatch($job)->delay($on);
                }else{
                    dispatch($job);
                }
            }
        }
        $title_ar = 'هناك طلب جديد';
        $title_en = 'there are a new order';
        $msg_ar = 'هناك طلب جديد رقم '.$order['order_num'];
        $msg_en = 'there is new order no.'.$order['order_num'];
        $user = $order->user;
        $user->notify(new NewOrder($title_ar,$title_en,$msg_ar,$msg_en,$order));
        return $this->successResponse();
    }
}
