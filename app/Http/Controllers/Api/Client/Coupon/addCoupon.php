<?php

namespace App\Http\Controllers\Api\Client\Coupon;

use App\Entities\Coupon;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class addCoupon extends Controller
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
            Cache::put('coupon_'.$order['id'],$coupon['id'],now()->addMinutes(10));
            $order = $this->orderRepo->find($request['order_id']);
            $total = (string) round($order->_price() ,2) - $couponValue;
            return $this->successResponse(['total'=> (string) $total,'value'=>(string) $couponValue]);
        }else{
            return $this->ApiResponse('fail',trans('api.coupon_expired'));
        }
    }
}
