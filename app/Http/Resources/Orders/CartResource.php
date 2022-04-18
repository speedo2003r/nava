<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Entities\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        $couponValue = 0;
        $coupon_id = Cache::get('coupon_'.$this->id);
        if($coupon_id) {
            $arrProducts = $this->orderServices()->pluck('service_id')->toArray();
            $coupon = Coupon::where('id', $coupon_id)->first();
            $couponValue = $coupon->couponValue($this['final_total'], $this['provider_id'], $arrProducts);
        }
        return [
            'id' => $this->id,
            'order_num' => $this->order_num ?? '',
            'services' => $this->services(),
            'tax' => (string) $this->vat_amount,
            'total' => (string) ($this->_price() - $couponValue),
        ];
    }
    private function services(){
        $categories = $this->orderServices()->distinct()->pluck('order_services.category_id')->toArray();
        $data = [];
        foreach ($categories as $value){
            $category = Category::find($value);
            $services = $this->orderServices()->where('order_services.category_id',$category['id'])->get();
            $data[] = [
                'id' => $category['id'],
                'title' => $category['title'],
                'image' => $category['icon'],
                'services' => $services->map(function ($q){
                    return [
                        'id' => $q['id'],
                        'title' => $q['title'],
                        'price' => $q['price'],
                        'count' => $q['count'],
//                        'image' => $q->service ? $q->service['image'] : '',
                    ];
                }),
                'total' => $services->sum('price')
            ];
        }
        return $data;
    }
}
