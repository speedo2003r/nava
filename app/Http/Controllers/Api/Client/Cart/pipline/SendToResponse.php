<?php
namespace App\Http\Controllers\Api\Client\Cart\pipline;

use App\Entities\Category;
use App\Repositories\OrderRepository;
use App\Repositories\ServiceRepository;
use App\Traits\ResponseTrait;

class SendToResponse{

    use ResponseTrait;
    public function __construct(protected ServiceRepository $service)
    {

    }

    public function handle($request,\Closure $next)
    {

        $order = $request['order'];
        $category = Category::find($request['category_id']);
        $data[] = [
            'id' => 0,
            'title' => app()->getLocale() == 'ar' ? 'طلب معاينه':'Request a preview',
            'description' => app()->getLocale() == 'ar' ? 'دع الفني يقيم المشكلة وسيتم خصم المبلغ من اجمالي الفاتورة':'Let the technician assess the problem and the amount will be deducted from the total bill',
            'price' => settings('preview_value') ? (double) settings('preview_value') : 0.00,
            'checked' => $order ? ($order->orderServices()->where('category_id',$category['id'])->where('preview_request',1)->exists()) : false,
            'count' => $order ? (int) $order->orderServices()->where('category_id',$category['id'])->where('preview_request',1)->sum('count') : 0,
        ];
        $services = $this->service->where('category_id',$category['id'])->get();
        foreach ($services as $service){
            $data[] = [
                'id' => $service['id'],
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
                'checked' => $order ? ($order->orderServices()->where('service_id',$service['id'])->exists()) : false,
                'count' => $order ? (int) ($order->orderServices()->where('service_id',$service['id'])->sum('count')) : 0,
            ];
        }
        $msg = app()->getLocale() == 'ar' ? 'تم الاضافه الي السله بنجاح' : 'successfully ad to cart';
        return $this->ApiResponse('success',$msg,[
            'services' => $data,
            'tax' => $order ? (string) $order['vat_amount'] : '0',
            'price' => $order ? (string) $order->_price() : '0',
        ]);
    }
}
