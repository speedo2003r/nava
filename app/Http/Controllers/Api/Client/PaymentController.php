<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Income;
use App\Entities\Order;
use App\Entities\OrderBill;
use App\Enum\PayType;
use App\Enum\PayStatus;
use App\Enum\WalletOperationType;
use App\Enum\WalletType;
use App\Enum\IncomeType;
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

    public function payApple(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL'
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = Order::find($request['order_id']);
        $price = $order->price();
        $checkout = $this->pre_checkout(number_format($price,2, '.', ','));
        return view('applePayPayment',compact('checkout','order'));
    }

    public function hyperApplePayResult(Request $request)
    {
        dd($request->all());
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

    public function walletPay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if ($validator->fails())
            return $this->ApiResponse('fail', $validator->errors()->first());

        $user = auth()->user();
        $order = Order::find($request['order_id']);
        $wallet = $user['wallet'];
        if($order->price() > $wallet){
            return $this->ApiResponse('fail',trans('api.walletNot'));
        }
        $user->wallets()->create([
            'amount' => $order->price(),
            'type' => WalletType::DEPOSIT,
            'created_by'=>$user['id'],
            'operation_type'=>WalletOperationType::WITHDRAWAL,
        ]);

        $order->pay_type = PayType::WALLET;
        $order->pay_status = PayStatus::DONE;
        $order->save();
        return $this->successResponse();
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
        $order->pay_type = PayType::CASH;
        $order->pay_status = PayStatus::DONE;
        $order->save();
        $technician = $order->technician;
        if($technician->company != null){
            $company = $technician->company;
            $commission = ($order['final_total'] * $company['commission']) / 100;
            if($order['pay_type'] == PayType::CASH){
                Income::create([
                    'user_id' => $company['id'],
                    'order_id'=>$order['id'],
                    'debtor' => $order->_price() - $commission,
                    'creditor'=>0,
                    'income'=>$commission,
                    'type'=>IncomeType::DEBTOR,
                ]);
            }
        }else{
            $commission = ($order['final_total'] * $technician['commission']) / 100;
            if($order['pay_type'] == PayType::CASH){
                Income::create([
                    'user_id' => $order['technician_id'],
                    'order_id'=>$order['id'],
                    'debtor' => $order->_price() - $commission,
                    'creditor'=>0,
                    'income'=>$commission,
                    'type'=>IncomeType::DEBTOR,
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
            $user->wallets()->create([
                'amount' => $checkout['amount'],
                'type' => WalletType::DEPOSIT,
                'created_by'=>$user['id'],
                'operation_type'=>WalletOperationType::DEPOSIT,
                'pay_type' => PayType::MADA,
                'pay_status' => PayStatus::DONE,
                'pay_data' => json_encode($checkout),
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
                'pay_type' => PayType::VISA,
                'pay_status' => PayStatus::DONE,
                'pay_data' => json_encode($checkout),
            ]);
            $bills = $order->bills()->where('order_bills.status',1)->get();
            if(count($bills) > 0){
                foreach ($bills as $bill){
                    $bill->update([
                        'pay_type' => PayType::VISA,
                        'pay_status' => PayStatus::DONE,
                        'pay_data' => json_encode($checkout),
                    ]);
                }
            }

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
                    'type'=>IncomeType::CREDITOR,
                ]);
                $company->wallets()->create([
                    'amount' => $commission,
                    'order_id' => $order['id'],
                    'type' => WalletType::DEPOSIT,
                    'created_by'=>$company['id'],
                    'operation_type'=>WalletOperationType::DEPOSIT,
                ]);
            }else{
                $commission = ($order['final_total'] * $technician['commission']) / 100;
                Income::create([
                    'user_id' => $order['technician_id'],
                    'order_id'=>$order['id'],
                    'debtor'=>0,
                    'creditor'=>$commission,
                    'income'=>$commission,
                    'type'=>IncomeType::CREDITOR,
                ]);
                $technician->wallets()->create([
                    'amount' => $commission,
                    'order_id' => $order['id'],
                    'type' => WalletType::DEPOSIT,
                    'created_by'=>$technician['id'],
                    'operation_type'=>WalletOperationType::DEPOSIT,
                ]);
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
                'pay_type' => PayType::VISA,
                'pay_status' => PayStatus::DONE,
                'pay_data' => json_encode($checkout),
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

            $user->wallets()->create([
                'amount' => $checkout['amount'],
                'type' => WalletType::DEPOSIT,
                'created_by'=>$user['id'],
                'operation_type'=>WalletOperationType::DEPOSIT,
                'pay_type' => PayType::VISA,
                'pay_status' => PayStatus::DONE,
                'pay_data' => json_encode($checkout),
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
                'pay_data' => json_encode($checkout),
                'pay_type' => PayType::MADA,
//                'status' => 'finished',
                'pay_status' => PayStatus::DONE,
            ]);
            $bills = $order->bills()->where('order_bills.status',1)->get();
            if(count($bills) > 0){
                foreach ($bills as $bill){
                    $bill->update([
                        'pay_type' => PayType::MADA,
                        'pay_status' => PayStatus::DONE,
                        'pay_data' => json_encode($checkout),
                    ]);
                }
            }
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
                        'type'=>IncomeType::CREDITOR,
                    ]);
                    $company->wallets()->create([
                        'amount' => $commission,
                        'order_id' => $order['id'],
                        'type' => WalletType::DEPOSIT,
                        'created_by'=>$company['id'],
                        'operation_type'=>WalletOperationType::DEPOSIT,
                    ]);
            }else{
                $commission = ($order['final_total'] * $technician['commission']) / 100;
                    Income::create([
                        'user_id' => $order['technician_id'],
                        'order_id'=>$order['id'],
                        'debtor'=>0,
                        'creditor'=>$commission,
                        'income'=>$commission,
                        'type'=>IncomeType::CREDITOR,
                    ]);
                    $technician->wallets()->create([
                        'amount' => $commission,
                        'order_id' => $order['id'],
                        'type' => WalletType::DEPOSIT,
                        'created_by'=>$technician['id'],
                        'operation_type'=>WalletOperationType::DEPOSIT,
                    ]);
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
                'pay_type' => PayType::MASTER,
                'pay_status' => PayStatus::DONE,
                'pay_data' => json_encode($checkout),
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
