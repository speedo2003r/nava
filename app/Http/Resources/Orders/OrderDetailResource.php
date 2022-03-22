<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Http\Resources\Users\AddressResource;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{

    public function toArray($request)
    {
        if($this->bills()->where('order_bills.status',0)->exists()) {
            $status = $this['pay_status'] == 'pending' ? 'new-invoice' : $this['status'];
        }else{
            $status = $this['status'];
        }
        return [
            'id'                => $this->id,
            'order_num'                => $this->order_num,
            'date'                => Carbon::parse($this->date)->translatedFormat('Y M d'),
            'time'                => Carbon::parse($this->time)->format('h:i a'),
            'category_title'                => $this->category ? $this->category['title'] : '',
            'category_image'                => $this->category ? $this->category['icon'] : '',
            'lat'                => $this['lat'],
            'lng'                => $this['lng'],
            'region'                => $this->region ? $this->region['title'] : '',
            'residence'                => $this['residence'] ?? '',
            'floor'                => $this['floor'] ?? '',
            'street'                => $this['street'] ?? '',
            'address_notes'                => $this['address_notes'] ?? '',
            'services'                => $this->services(),
            'tax'                => $this->tax(),
            'total'                =>   (string) round($this->price(),1),
            'status'                =>   $status,
            'pay_type'                =>   $this['pay_type'] ?? 'cash',
            'is_payment'                =>   $this->pay_status == 'pending' && $status == 'in-progress',
        ];
    }

    private function isPaid(){
        $bills = $this->bills()->where('order_bills.status',1)->where('order_bills.pay_type','!=','cash')->get();
        $total = ($bills->sum('price') + $bills->sum('vat_amount'));
        return (string) round($total, 2);
    }
    private function services(){
        $categories = $this->orderServices()->where('order_services.status',1)->distinct()->pluck('order_services.category_id')->toArray();
        $data = [];
        foreach ($categories as $value){
            $category = Category::find($value);
            $services = $this->orderServices()->where('order_services.status',1)->where('order_services.category_id',$category['id'])->get();
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
                        'count' => $q['count'],
                        'price' => $q['price'],
                        'image' => $q->service ? $q->service['image'] : '',
                    ];
                }),
                'total' => $total
            ];
        }
        return $data;
    }
}
