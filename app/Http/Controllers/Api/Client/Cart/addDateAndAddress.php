<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class addDateAndAddress extends Controller
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
            'date' => 'required|date|after:'.Carbon::yesterday()->format('Y-m-d'),
            'time' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required|string|max:250',
            'region_id' => 'required|exists:regions,id,deleted_at,NULL',
            'address_notes' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        if(Carbon::now()->format('Y-m-d H:i:s') > Carbon::parse($request['date'])->format('Y-m-d').' '.Carbon::parse($request['time'])->format('H:i:s')){
            return $this->ApiResponse('fail', trans('api.timemustbe'));
        }
        $order = $this->orderRepo->find($request['order_id']);

        $mini_order_charge = settings('mini_order_charge');
        $increase = 0;
        $increase_tax = 0;
        $tax = $order['vat_amount'];
        if($order['increased_price'] > 0 && $order['final_total'] > $mini_order_charge){
            $increase = ($order['final_total'] < $mini_order_charge) ? $mini_order_charge - $order['final_total'] : 0;
            $increase_tax = ($order['final_total'] < $mini_order_charge) ? (($increase * $order['vat_per']) / 100) : 0;
        }
        $this->orderRepo->update([
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'time' => Carbon::parse($request['time'])->format('H:i:s'),
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'map_desc' => $request['address'],
            'region_id' => $request['region_id'],
            'increased_price' => $increase,
            'increase_tax' => $increase_tax,
            'vat_amount' => $tax,
            'address_notes' => $request['address_notes'],
        ],$order['id']);
        return $this->successResponse();
    }
}
