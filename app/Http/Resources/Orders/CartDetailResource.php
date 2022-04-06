<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Entities\OrderProduct;
use App\Entities\UserAddress;
use App\Http\Resources\Users\AddressResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDetailResource extends JsonResource
{
    public function toArray($request)
    {
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
            'total'                => (string) ($this->_price() + $this['increased_price']),
            'mini_order_charge'                => $mini_order_charge,
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
                        'image' => $q->service ? $q->service['image'] : '',
                    ];
                }),
                'total' => $services->sum('price')
            ];
        }
        return $data;
    }
}
