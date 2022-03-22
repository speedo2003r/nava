<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Income;
use App\Entities\Order;
use App\Entities\OrderBill;
use App\Jobs\SendDelegateOrder;
use App\Jobs\SendToDelegate;
use App\Models\User;
use App\Traits\HyperpayTrait;
use App\Http\Controllers\Controller;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    use HyperpayTrait;
    use ResponseTrait;
    use NotifyTrait;
    public function payVisa(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = Order::find($request['order_id']);
//        if($order->region == null){
//            $msg = app()->getLocale() == 'ar' ? 'من فضلك أضف عنوان أولا للطلب' : 'Please add a title first to order';
//            return $this->ApiResponse('fail', $msg);
//        }
        $price = $order->price();
        $checkout = $this->pre_checkout(number_format($price,2, '.', ','));
        return view('onlinePayment',compact('checkout','order'));
    }
    public function payInvoiceVisa(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bill_id' => 'required|exists:order_bills,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = OrderBill::find($request['bill_id']);
        $price = $order->_price();
        $checkout = $this->pre_checkout(number_format($price,2, '.', ','));
        return view('onlineInvoicePayment',compact('checkout','order'));
    }
    public function payWalletVisa(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required',
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = User::find($request['user_id']);
        $price = $request['amount'];
        $checkout = $this->pre_checkout(number_format($price,2, '.', ','));
        return view('onlineWalletPayment',compact('checkout','user'));
    }
    public function payMada(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = Order::find($request['order_id']);
//        if($order->region == null){
//            $msg = app()->getLocale() == 'ar' ? 'من فضلك أضف عنوان أولا للطلب' : 'Please add a title first to order';
//            return $this->ApiResponse('fail', $msg);
//        }
        $price = $order->price();
        $checkout = $this->mada_pre_checkout(number_format($price,2, '.', ','));
        return view('MadaPayment',compact('checkout','order'));
    }
    public function payCash(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = Order::find($request['order_id']);
        $order->pay_type = 'cash';
        $order->pay_status = 'done';
//        $order->status = 'finished';
        $order->save();
        $technician = $order->technician;
        if($technician->company != null){
            $company = $technician->company;
            $commission = ($order['final_total'] * $company['commission']) / 100;
            if($order['pay_type'] == 'cash'){
                Income::create([
                    'user_id' => $company['id'],
                    'order_id'=>$order['id'],
                    'debtor' => $order->_price() - $commission,
                    'creditor'=>0,
                    'income'=>$commission,
                ]);
            }
        }else{
            $commission = ($order['final_total'] * $technician['commission']) / 100;
            if($order['pay_type'] == 'cash'){
                Income::create([
                    'user_id' => $order['technician_id'],
                    'order_id'=>$order['id'],
                    'debtor' => $order->_price() - $commission,
                    'creditor'=>0,
                    'income'=>$commission,
                ]);
            }
        }
        return $this->successResponse();
    }

    public function payInvoiceMada(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bill_id' => 'required|exists:order_bills,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = OrderBill::find($request['bill_id']);
        $price = $order->_price();
        $checkout = $this->mada_pre_checkout(number_format($price,2, '.', ','));
        return view('MadaInvoicePayment',compact('checkout','order'));
    }
    public function payWalletMada(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required',
            'user_id' => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = User::find($request['user_id']);
        $price = $request['amount'];
        $checkout = $this->mada_pre_checkout(number_format($price,2, '.', ','));
        return view('MadaWalletPayment',compact('checkout','user'));
    }

    public function madaHyperWalletResult(Request $request)
    {
        $id = $request['id'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $checkout = $this->mada_payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $user->update([
                'wallet' => $user['wallet'] + $checkout['amount'],
            ]);

            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('madaHyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
    public function hyperResult(Request $request)
    {
        $id = $request['id'];
        $order_id = $request['order_id'];
        $order = Order::find($order_id);
        $checkout = $this->payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $order->update([
                'pay_type' => 'visa',
                'pay_status' => 'done',
//                'status' => 'finished',
                'pay_data' => $checkout,
            ]);
            $bills = $order->bills()->where('order_bills.status',1)->get();
            if(count($bills) > 0){
                foreach ($bills as $bill){
                    $bill->update([
                        'pay_type' => 'visa',
                        'pay_status' => 'done',
                        'pay_data' => $checkout,
                    ]);
                }
            }

            $branch = $order->region->branches()->first();
            if($branch){
                $on = \Carbon\Carbon::now()->addMinutes((int) $branch['assign_deadline'] ?? 0);
                $users = User::where('user_type','technician')->exist()->whereHas('branches',function ($query) use ($branch){
                    $query->where('users_branches.branch_id',$branch['id']);
                })->get();
                foreach($users as $user) {
                    $job = (new SendToDelegate($order['id'],$user['id']));
                    if($branch['assign_deadline'] > 0){
                        dispatch($job)->delay($on);
                    }else{
                        dispatch($job);
                    }
                }
            }
            $msg_ar = 'هناك طلب جديد رقم '.$order['order_num'];
            $msg_en = 'there is new order no.'.$order['order_num'];
            $this->send_notify($order['user_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
//            return redirect()->route('hyperResult',['type'=>'success']);
            $technician = $order->technician;
            if($technician->company != null){
                $company = $technician->company;
                $commission = ($order['final_total'] * $company['commission']) / 100;
                Income::create([
                    'user_id' => $company['id'],
                    'order_id'=>$order['id'],
                    'debtor'=>0,
                    'creditor'=>$commission,
                    'income'=>$commission,
                ]);
                if($company['balance'] > 0 && $company['balance'] <= $commission){
                    $value = $commission - $company['balance'];
                    $company['balance'] = 0;
                    $company['wallet'] += $value;
                    $company->save();
                }elseif($company['balance'] > 0 && $company['balance'] >= $commission){
                    $value = $company['balance'] - $commission;
                    $company['balance'] = $value;
                    $company->save();
                }else{
                    $company['wallet'] += $commission;
                }
            }else{
                $commission = ($order['final_total'] * $technician['commission']) / 100;
                Income::create([
                    'user_id' => $order['technician_id'],
                    'order_id'=>$order['id'],
                    'debtor'=>0,
                    'creditor'=>$commission,
                    'income'=>$commission,
                ]);
                if($technician['balance'] > 0 && $technician['balance'] <= $commission){
                    $value = $commission - $technician['balance'];
                    $technician['balance'] = 0;
                    $technician['wallet'] += $value;
                    $technician->save();
                }elseif($technician['balance'] > 0 && $technician['balance'] >= $commission){
                    $value = $technician['balance'] - $commission;
                    $technician['balance'] = $value;
                    $technician->save();
                }else{
                    $technician['wallet'] += $commission;
                }
            }
            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('hyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
    public function hyperInvoiceResult(Request $request)
    {
        $id = $request['id'];
        $order_id = $request['order_id'];
        $order = OrderBill::find($order_id);
        $checkout = $this->payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $order->update([
                'pay_type' => 'visa',
                'pay_status' => 'done',
                'pay_data' => $checkout,
            ]);

            $orderServices = $order->orderServices;
            if(count($orderServices) > 0){
                foreach ($orderServices as $orderService){
                    $orderService->status = 1;
                    $orderService->save();
                }
            }
            $data = $order->order;
            $data->vat_amount = $data->tax() - $data['increase_tax'];
            $data->final_total = $data->price() - $data['increased_price'];
            $data->total_services = $data->orderServices('order_services.status',1)->count();
            $data->save();
//            return redirect()->route('hyperResult',['type'=>'success']);
            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('hyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
    public function hyperWalletResult(Request $request)
    {
        $id = $request['id'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $checkout = $this->payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $user->update([
                'wallet' => $user['wallet'] + $checkout['amount'],
            ]);
//            return redirect()->route('hyperResult',['type'=>'success']);
            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('hyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
    public function madaHyperResult(Request $request)
    {
        $id = $request['id'];
        $order_id = $request['order_id'];
        $order = Order::find($order_id);
        $checkout = $this->mada_payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $order->update([
                'pay_data' => $checkout,
                'pay_type' => 'mada',
//                'status' => 'finished',
                'pay_status' => 'done',
            ]);
            $bills = $order->bills()->where('order_bills.status',1)->get();
            if(count($bills) > 0){
                foreach ($bills as $bill){
                    $bill->update([
                        'pay_type' => 'mada',
                        'pay_status' => 'done',
                        'pay_data' => $checkout,
                    ]);
                }
            }
            $branch = $order->region->branches()->first();
            if($branch){
                $on = \Carbon\Carbon::now()->addMinutes((int) $branch['assign_deadline'] ?? 0);
                $users = User::where('user_type','technician')->exist()->whereHas('branches',function ($query) use ($branch){
                    $query->where('users_branches.branch_id',$branch['id']);
                })->get();
                foreach($users as $user) {
                    $job = (new SendDelegateOrder($order,$user));
                    dispatch($job)->delay($on);
                }
            }
            $msg_ar = 'هناك طلب جديد رقم '.$order['order_num'];
            $msg_en = 'there is new order no.'.$order['order_num'];
            $this->send_notify($order['user_id'],$msg_ar,$msg_en,$order['id'],$order['status']);
//            return redirect()->route('madaHyperResult',['type'=>'success']);
            $technician = $order->technician;
            if($technician->company != null){
                $company = $technician->company;
                $commission = ($order['final_total'] * $company['commission']) / 100;
                    Income::create([
                        'user_id' => $company['id'],
                        'order_id'=>$order['id'],
                        'debtor'=>0,
                        'creditor'=>$commission,
                        'income'=>$commission,
                    ]);
                    if($company['balance'] > 0 && $company['balance'] <= $commission){
                        $value = $commission - $company['balance'];
                        $company['balance'] = 0;
                        $company['wallet'] += $value;
                        $company->save();
                    }elseif($company['balance'] > 0 && $company['balance'] >= $commission){
                        $value = $company['balance'] - $commission;
                        $company['balance'] = $value;
                        $company->save();
                    }else{
                        $company['wallet'] += $commission;
                    }
            }else{
                $commission = ($order['final_total'] * $technician['commission']) / 100;
                    Income::create([
                        'user_id' => $order['technician_id'],
                        'order_id'=>$order['id'],
                        'debtor'=>0,
                        'creditor'=>$commission,
                        'income'=>$commission,
                    ]);
                    if($technician['balance'] > 0 && $technician['balance'] <= $commission){
                        $value = $commission - $technician['balance'];
                        $technician['balance'] = 0;
                        $technician['wallet'] += $value;
                        $technician->save();
                    }elseif($technician['balance'] > 0 && $technician['balance'] >= $commission){
                        $value = $technician['balance'] - $commission;
                        $technician['balance'] = $value;
                        $technician->save();
                    }else{
                        $technician['wallet'] += $commission;
                    }
            }
            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('madaHyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
    public function madaHyperInvoiceResult(Request $request)
    {
        $id = $request['id'];
        $order_id = $request['order_id'];
        $order = OrderBill::find($order_id);
        $checkout = $this->mada_payment_status($id);
        $code = $checkout['result']['code'];
        if(is_success($code)){
            $order->update([
                'pay_type' => 'master',
                'pay_status' => 'done',
                'pay_data' => $checkout,
            ]);

            $data = $order->order;
            $data->vat_amount = $data->tax() - $data['increase_tax'];
            $data->final_total = $data->price() - $data['increased_price'];
            $data->total_services = $data->orderServices('order_services.status',1)->count();
            $data->save();
            return redirect()->to('/api/success');
        }else{
            $msg = app()->getLocale() == 'ar' ? 'لا يمكن اتمام عملية الدفع لوجود خطأ ما' : 'payment not will be completed because there are an error';
//            return redirect()->route('madaHyperResult',['type'=>'fail']);
            return redirect()->to('/api/fail');
        }
    }
}
