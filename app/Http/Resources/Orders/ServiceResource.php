<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order->order_num ?? '',
            'services' => $this->services(),
            'tax' => $this->vat_amount,
            'total' => $this->_price(),
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
                'services' => $services->map(function ($q){
                    return [
                        'id' => $q['id'],
                        'title' => $q['title'],
                        'price' => $q['price'] * $q['count'],
                    ];
                }),
                'total' => $total
            ];
        }
        return $data;
    }
}
