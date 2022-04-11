<?php

namespace App\Repositories;

use App\Entities\Category;
use App\Entities\OrderBill;
use App\Entities\OrderService;
use App\Entities\Service;
use App\Repositories\OrderRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Order;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    public function storeOrder($request)
    {
        $user_id = auth()->check() ? auth()->id() : null;
        if(isset($request['service_id']) && $request['service_id'] > 0){
            $service = Service::find($request['service_id']);
            $category = Category::find($request['category_id']);
            $order = $this->model->create([
                'uuid' => $request['uuid'],
                'total_services' => 1,
                'city_id' => $request['city_id'],
                'user_id' => $user_id,
                'category_id' => $category['parent_id'],
                'vat_per' => settings('tax') ?? 0,
                'vat_amount' => ($service['price'] * settings('tax') ?? 0) / 100,
                'final_total' => $service['price'],
            ]);
        }else{
            $category = Category::find($request['category_id']);
            $order = $this->model->create([
                'uuid' => $request['uuid'],
                'total_services' => 1,
                'city_id' => $request['city_id'],
                'user_id' => $user_id,
                'category_id' => $category['parent_id'],
                'vat_per' => settings('tax') ?? 0,
                'vat_amount' => (settings('preview_value') * settings('tax') ?? 0) / 100,
                'final_total' => settings('preview_value') ?? 0,
            ]);
        }

        $this->orderProductStore($order, $request);
        return $order;
    }

    public function updateOrder($data, $request)
    {
        if(isset($request['service_id']) && $request['service_id'] > 0) {
            $orderService = OrderService::where('order_id', $data['id'])->where('service_id', $request['service_id'])->first();
            if ($request['counter'] == 'up') {
                $service = Service::find($request['service_id']);
                $tax = ($service['price'] * settings('tax')) / 100;
                $data->update([
                    'total_services' => $data['total_services'] + 1,
                    'vat_amount' => $data['vat_amount'] + $tax,
                    'final_total' => $data['final_total'] + $service['price'],
                ]);
                if ($orderService == null) {
                    $this->orderProductStore($data, $request);
                } else {
                    $orderService->count = $orderService->count + 1;
                    $orderService->save();
                }
            } else {
                $serviceData = $orderService;
                if ($orderService == null) {
                    $serviceData = Service::find($request['service_id']);
                    $tax = ($serviceData['price'] * settings('tax') ?? 0) / 100;
                } else {
                    $tax = $orderService['tax'];
                    if ($orderService['count'] == 1) {
                        $orderService->forceDelete();
                    }
                    $orderService->count = $orderService->count - 1;
                    $orderService->save();
                }
                $data->update([
                    'total_services' => $data['total_services'] - 1,
                    'vat_amount' => $data['vat_amount'] - $tax,
                    'final_total' => $data['final_total'] - $serviceData['price'],
                ]);
            }
        }else{
            if(!$data->orderServices()->where('category_id',$request['category_id'])->where('preview_request',1)->exists()){
                $data->update([
                    'total_services' => $data['total_services'] + 1,
                    'vat_amount' => $data['vat_amount'] + ((settings('preview_value') ?? 0) * settings('tax') ?? 0) / 100,
                    'final_total' => $data['final_total'] + settings('preview_value') ?? 0,
                ]);
                $this->orderProductStore($data, $request);
            }else{
                $dataService = $data->orderServices()->where('category_id',$request['category_id'])->where('preview_request',1)->first();
                $tax = $dataService['tax'];
                $price = $dataService['price'];
                $data->update([
                    'total_services' => $data['total_services'] - 1,
                    'vat_amount' => $data['vat_amount'] - $tax,
                    'final_total' => $data['final_total'] - $price,
                ]);
                $dataService->forceDelete();
            }
        }

    }

    public function orderProductStore($data, $request)
    {
        if(isset($request['service_id']) && $request['service_id'] > 0){
            $service = Service::find($request['service_id']);
            OrderService::create([
                'title' => $service['title'],
                'type' => $service['type'],
                'status' => 1,
                'order_id' => $data['id'],
                'category_id' => $request['category_id'],
                'service_id' => $service['id'],
                'price' => $service['price'],
                'tax' => ($service['price'] * settings('tax') ?? 0) / 100,
            ]);
        }else{
            OrderService::create([
                'title' => [
                    'ar' => 'طلب معاينه',
                    'en' => 'Request a preview',
                ],
                'type' => 'fixed',
                'status' => 1,
                'order_id' => $data['id'],
                'category_id' => $request['category_id'],
                'preview_request' => 1,
                'price' => settings('preview_value') ?? 0,
                'tax' => (settings('preview_value') * settings('tax') ?? 0) / 100,
            ]);
        }

    }

    public function addStatusTimeLine($order_id,$status)
    {
        $order = $this->model->find($order_id);
        $order->timeLineStatus()->create([
            'status' => $status
        ]);
    }
    public function addBillStatusTimeLine($order_bill_id,$status)
    {
        $orderBill = OrderBill::find($order_bill_id);
        $order = $orderBill->order;
        $order->timeLineStatus()->create([
            'order_bill_id' => $order_bill_id,
            'status' => $status
        ]);
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
