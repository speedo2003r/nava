<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Order;
use App\Entities\OrderBill;
use App\Entities\OrderGuarantee;
use App\Entities\OrderService;
use App\Entities\ReviewRate;
use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Orders\CartDetailResource;
use App\Http\Resources\Orders\CartResource;
use App\Http\Resources\Orders\OrderBillResource;
use App\Http\Resources\Orders\OrderDetailResource;
use App\Http\Resources\Orders\OrderResource;
use App\Jobs\SendToDelegate;
use App\Models\User;
use App\Notifications\Api\AcceptInvoice;
use App\Notifications\Api\FinishOrder;
use App\Notifications\Api\NewOrder;
use App\Notifications\Api\RefuseInvoice;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderServiceRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
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

    public function cancelOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        if(!in_array($order['status'],['created','user_cancel'])){
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن الغاء هذا الطلب' : 'This request cannot be cancelled';
            return $this->ApiResponse('fail', $msg);
        }
        $this->orderRepo->update([
            'status' => 'user_cancel',
            'canceled_by' => auth()->id(),
        ],$order['id']);
        return $this->successResponse();
    }
    public function placeOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'pay_type' => 'required|in:cash,wallet,visa,mada',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
//        $mini_order_charge = settings('mini_order_charge');
//        if($order->_price() <= $mini_order_charge){
//            $msg = app()->getLocale() == 'ar' ? 'يجب أن يكون الحد الأدني للطلب أكبر من قيمة '.$mini_order_charge : 'The minimum order must be greater than the value '.$mini_order_charge;
//            return $this->ApiResponse('fail', $msg);
//        }
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
        $branch = $order->region->branches()->first();
//        if($request['pay_type'] == 'cash'){
            if($branch){
                $on = now()->addMinutes((int) $branch['assign_deadline'] ?? 0);
                $users = User::where('user_type','technician')->exist()->whereHas('branches',function ($query) use ($branch){
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
//        }
        return $this->successResponse();
    }
    public function MyOrders(LangRequest $request,$type)
    {
        $user = auth()->user();
        if($type == 'current'){
            $orders = $user->ordersAsUser()->where('live',1)->whereNotIn('status',['finished','canceled'])->latest()->get();
        }else{
            $orders = $user->ordersAsUser()->where('live',1)->where('status','finished')->latest()->get();
        }
        return $this->successResponse(OrderResource::collection($orders));
    }
    public function OrderDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if($order['live'] == 0){
            $msg = 'لم يتم تنفيذ الطلب بعد';
            return $this->ApiResponse( 'fail', $msg);
        }

        if($order->bills()->where('order_bills.status',0)->exists()){
            $allStatus = Order::userStatusWithBill();
            $status = 'new-invoice';
            $invoice = true;
            $bill_id = $order->bills()->where('order_bills.status',0)->first()['id'];
        }else{
            $allStatus = Order::userStatus();
            $status = $order['status'];
            $invoice = false;
            $bill_id = 0;
        }
        $order->refresh();
        return $this->successResponse([
            'allStatus' => $allStatus,
            'status_name' => $status == 'new-invoice' ? Order::userStatusWithBill($status) : Order::userStatus($status),
            'status' => $status,
            'details' => new OrderDetailResource($order),
            'invoice' => $invoice,
            'pay_type'                => $order['pay_type'] ? __($order['pay_type']) : '',
//            'pay_type' => $order['pay_type'] ?? '',
            'bill_id' => $bill_id,
        ]);
    }

    public function invoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        return $this->successResponse(OrderBillResource::make($orderBill));
    }
    public function refuseInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
            'refuse_reason' => 'required',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        $orderBill->status = 2;
        $orderBill->refuse_reason = $request['refuse_reason'];
        $orderBill->save();
        $order = $orderBill->order;
        $technician = $order->technician;
        $msg_ar = 'تم رفض الفاتوره في الطلب رقم '.$order['order_num'];
        $msg_en = 'invoice has been refused in order No '.$order['order_num'];
        $technician->notify(new RefuseInvoice($msg_ar,$msg_en,$msg_ar,$msg_en));
        return $this->successResponse();
    }

    public function acceptInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        $orderBill->status = 1;
        $orderBill->save();
        $orderServices = $orderBill->orderServices;
        if(count($orderServices) > 0){
            foreach ($orderServices as $orderService){
                $orderService->status = 1;
                $orderService->save();
            }
        }
        $order = $orderBill->order;
        $technician = $order->technician;
        $order->vat_amount = $order->tax() - $order['increase_tax'];
        $order->final_total = $order->price() - $order['increased_price'];
        $order->total_services = $order->orderServices('order_services.status',1)->count();
        $order->save();

        $msg_ar = 'تم الموافقه علي الفاتوره في الطلب رقم '.$order['order_num'];
        $msg_en = 'invoice has been accepted in order No '.$order['order_num'];
        $technician->notify(new AcceptInvoice($msg_ar,$msg_en,$msg_ar,$msg_en));
        return $this->successResponse();
    }

    public function walletBillPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $orderBill = OrderBill::find($request['bill_id']);
        $wallet = $user['wallet'];
        if($orderBill->_price() > $wallet){
            return $this->ApiResponse('fail',trans('api.walletNot'));
        }
        $user['wallet'] -= $orderBill->_price();
        $user->save();
        $orderBill->pay_type = 'wallet';
        $orderBill->status = 1;
        $orderBill->save();
        $orderServices = $orderBill->orderServices;
        if(count($orderServices) > 0){
            foreach ($orderServices as $orderService){
                $orderService->status = 1;
                $orderService->save();
            }
        }
        $order = $orderBill->order;
        $order->vat_amount = $order->tax() - $order['increase_tax'];
        $order->final_total = $order->price() - $order['increased_price'];
        $order->total_services = count($order->orderServices);
        $order->save();
        return $this->successResponse();
    }
    public function cashBillPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required|exists:order_bills,id',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $orderBill = OrderBill::find($request['bill_id']);
        $orderBill->pay_type = 'cash';
        $orderBill->status = 1;
        $orderBill->save();
        $orderServices = $orderBill->orderServices;
        if(count($orderServices) > 0){
            foreach ($orderServices as $orderService){
                $orderService->status = 1;
                $orderService->save();
            }
        }
        $order = $orderBill->order;
        $order->vat_amount = $order->tax() - $order['increase_tax'];
        $order->final_total = $order->price() - $order['increased_price'];
        $order->total_services = $order->orderServices('order_services.status',1)->count();
        $order->save();
        return $this->successResponse();
    }
    public function walletPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        $wallet = $user['wallet'];
        if($order->price() > $wallet){
            return $this->ApiResponse('fail',trans('api.walletNot'));
        }
        $user['wallet'] -= $order->price();
        $user->save();

        $order->pay_type = 'wallet';
        $order->pay_status = 'done';
        $order->save();
        return $this->successResponse();
    }

    public function rateOrderTech(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'rate' => 'required',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $technician = $order->technician;
        if($technician){
            ReviewRate::create([
                'user_id' => $user['id'],
                'order_id' => $order['id'],
                'rateable_id' => $technician['id'],
                'rateable_type' => get_class($technician),
                'rate' => $request['rate'],
            ]);
        }else{
            return $this->ApiResponse( 'fail', 'technician is undefined');
        }
        return $this->successResponse();
    }

    public function finishOrder(LangRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
            'pay_type' => 'required|in:cash,visa,master,apple,stc',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $total = $order->_price();
        $orderInstallment = $order->orderInstallments()->where('deposit','=',true)->first();

        $order->orderInstallments()->create([
            'amount' => $total - $orderInstallment['amount'],
            'pay_type' => $request['pay_type'],
        ]);
        $this->orderRepo->update([
            'status' => 'done'
        ],$order['id']);
        $user = $order->user;
        $title_ar = 'تم انهاء الطلب';
        $title_en = 'there is order has been completed';
        $msg_ar = 'تم انهاء الطلب رقم '.$order['order_num'];
        $msg_en = 'Order No. has been completed'.$order['order_num'];
        $user->notify(new FinishOrder($title_ar,$title_en,$msg_ar,$msg_en,$order));
        return $this->successResponse();
    }
    public function downloadPdf(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                 <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
                 <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
            );
        }];
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $data = $order['contract'];
        $pdf = PDF::loadView('pdf', compact('data'), [], $config);
        return $pdf->download('contract.pdf');

    }
    public function viewContract(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $data = $order['contract'];
        return $this->successResponse($data ?? '');
    }

    public function orderGuarantee(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $order = $this->orderRepo->find($request['order_id']);
        if ($order['user_id'] != $user['id']) {
            return $this->ApiResponse( 'fail', 'order is undefined');
        }
        $guarantee = $order->guarantee;
        if($guarantee){
            if($guarantee['start_date'] <= Carbon::now()->format('Y-m-d') && $guarantee['end_date'] >= Carbon::now()->format('Y-m-d')){
                $guarantee->status = 1;
                $guarantee->technical_id = $order['technician_id'];
                $guarantee->save();
            }else{
                $msg = app()->getLocale() == 'ar' ? 'لقد انتهت فترة الضمان' : 'Warranty period has expired';
                return $this->ApiResponse( 'fail', $msg);
            }
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يوجد لهذا الطلب ضمان' : 'There is no guarantee for this order';
            return $this->ApiResponse( 'fail', $msg);
        }
        return $this->successResponse();
    }
}
