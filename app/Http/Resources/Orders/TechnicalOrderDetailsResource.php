<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Entities\Order;
use App\Entities\OrderProduct;
use App\Entities\UserAddress;
use App\Enum\OrderStatus;
use App\Http\Resources\Users\AddressResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalOrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'order_num'                => $this->order_num,
            'status'   => (!in_array($this['status'],['finished','canceled','created']) && $this['technician_id'] != null)  ? trans('api.notdoneyet') : (in_array($this['status'],['finished','canceled']) ? trans('api.done') : trans('api.new')),
            'order_status' => $this['status'] ?? '',
            'allStatus' => Order::userStatusWithBill(),
            'name'                => $this->user['name'],
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
            'notes'                => $this['notes'] ?? '',
            'services'                => $this->services(),
            'bills'                => $this->orderBills(),
            'files'                => $this->orderFiles(),
            'tax'                => $this->status == OrderStatus::FINISHED ? (string) round($this->vat_amount,2) : $this->tax(),
            'isPaid'                => $this->isPaid(),
            'total'                =>   $this->status == OrderStatus::FINISHED ? (string) round($this->final_total,2) : $this->price(),
            'pay_type'                => __($this->pay_type),
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

    public function orderFiles()
    {
        $files = [];
        if(count($this->files) > 0){
            $files = $this->files->map(function ($query){
                return [
                    'id' => $query['id'],
                    'image' => dashboard_url('storage/images/orders/'. $query['image']),
                    'type' => $query['media_type'],
//                    'type' => substr($query['image'],-3) == 'mp3' ? 'audio' : (in_array(substr($query['image'],-3),['mp4','aac','MOV','mov','m4a']) ? 'video' : 'image'),
                ];
            });
        }
        return $files;
    }
    private function orderBills(){
        $bills = $this->bills()->where('order_bills.status',1)->whereDoesntHave('orderServices')->get();
        if(count($bills) > 0){
            $bills = $bills->map(function ($q){
                return [
                    'id' => $q['id'],
                    'text' => $q['text'],
                    'price' => (string) round($q['price'],2),
                    'tax' => (string) round($q['vat_amount'],2),
                ];
            });
        }
        return $bills;
    }
}
