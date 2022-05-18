<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Entities\Coupon;
use App\Entities\OrderProduct;
use App\Entities\UserAddress;
use App\Http\Resources\Users\AddressResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class CartDetailResource extends JsonResource
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
        $mini_order_charge = settings('mini_order_charge');
        return [
            'id'                => $this->id,
            'order_num'                => $this->order_num,
            'date'                => Carbon::parse($this->date)->translatedFormat('Y M d'),
            'time'                => Carbon::parse($this->time)->format('h:i a'),
            'category_title'                => $this->category['title'],
            'lat'                => $this['lat'],
            'lng'                => $this['lng'],
            'region'                => $this->region ? $this->region['title'] : '',
            'residence'                => $this['residence'] ?? '',
            'floor'                => $this['floor'] ?? '',
            'street'                => $this['street'] ?? '',
            'address_notes'                => $this['address_notes'] ?? '',
            'services'                => $this->services(),
            'tax'                => $this['vat_amount'],
            'total'                => (string) (($this->_price() + $this['increased_price']) - $couponValue),
            'couponValue' => (string) $couponValue,
            'mini_order_charge'                => $mini_order_charge,
        ];
    }

    private function services(){
        $categories = $this->orderServices()->distinct()->pluck('order_services.category_id')->toArray();
        $data = [];
        foreach ($categories as $value){
            $category = Category::find($value);
            $services = $this->orderServices()->where('order_services.category_id',$category['id'])->get();
            $total = 0;
            foreach ($services as $service){
                $total += $service['price'] * $service['count'];
            }
            $data[] = [
                'id' => $category['id'],
                'title' => $category['title'],
                'image' => $category['icon'],
                'services' => $services->map(function ($q){
                    return [
                        'id' => $q['id'],
                        'title' => $q['title'],
                        'price' => $q['price'] * $q['count'],
                        'image' => $q->service ? $q->service['image'] : '',
                    ];
                }),
                'total' => $total
            ];
        }
        return $data;
    }
}
