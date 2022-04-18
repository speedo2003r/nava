<?php
namespace App\Http\Controllers\Api\Client\Cart\pipline;

use App\Entities\Category;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Cache;

class StoreCart{

    public function __construct(protected OrderRepository $orderRepo)
    {

    }

    public function handle($request,\Closure $next)
    {
        $order = $request['order'];
        if($request['unchecked'] == 1){
            if($order){
                if($request['service_id'] > 0) {
                    if ($order->orderServices()->where('service_id', $request['service_id'])->exists()) {
                        $orderService = $order->orderServices()->where('service_id', $request['service_id'])->first();
                        $price = $orderService['price'] * $orderService['count'];
                        $tax = $orderService['tax'] * $orderService['count'];
                        $order->update([
                            'final_total' => $order['final_total'] - $price,
                            'vat_amount' => $order['vat_amount'] - $tax,
                        ]);
                        $coupon_id = Cache::get('coupon_'.$order['id']);
                        if($coupon_id){
                            Cache::forget('coupon_'.$order['id']);
                        }
                        $order->orderServices()->where('service_id', $request['service_id'])->delete();
                    }
                }
            }
        }else{
            if($order == null){
                $order = $this->orderRepo->storeOrder(array_filter($request));
            }else{
                $category = Category::find($request['category_id']);
                $coupon_id = Cache::get('coupon_'.$order['id']);
                if($coupon_id){
                    Cache::forget('coupon_'.$order['id']);
                }
                if($order['category_id'] == $category['parent_id']){
                    $this->orderRepo->updateOrder($order,array_filter($request));
                }else{
                    $order->forceDelete();
                    $order = $this->orderRepo->storeOrder(array_filter($request));
                }
            }
        }
        $order->refresh();
        $request['order'] = $order;
        return $next($request);
    }
}
