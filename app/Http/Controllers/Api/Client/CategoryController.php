<?php

namespace App\Http\Controllers\Api\Client;
use App\Entities\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\services\ServiceResource;
use App\Http\Resources\Settings\BannerResource;
use App\Http\Resources\Settings\CategoryResource;
use App\Http\Resources\Settings\SliderResource;
use App\Http\Resources\Users\ProviderCollection;
use App\Http\Resources\Users\ProviderResource;
use App\Models\User;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller{

    use ResponseTrait;
    public $userRepo,$categoryRepo,$service,$orderRepo;
    public function __construct(OrderRepository $orderRepo,ServiceRepository $service,UserRepository $user,CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->categoryRepo = $category;
        $this->service = $service;
        $this->orderRepo = $orderRepo;
    }

    public function subCategories(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $category = $this->categoryRepo->find($request['category_id']);
        $subCategories = $category->children()->where('status',1)->get();
        return $this->successResponse(CategoryResource::collection($subCategories));
    }
    public function SingleCategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subcategory_id' => 'required|exists:categories,id,deleted_at,NULL',
            'uuid' => 'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $category = $this->categoryRepo->find($request['subcategory_id']);
        $parent = $category->parent;
        $user_id = auth()->check() ? auth()->id() : null;

        if($user_id != null){
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',$user_id)->where('live',0)->first();
        }else{
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',null)->where('live',0)->first();
        }
        if($order && count($order->orderServices) == 0 && $order->_price() > 0){
            $order->delete();
        }
        $data[] = [
            'id' => 0,
            'title' => app()->getLocale() == 'ar' ? 'طلب معاينه':'Request a preview',
            'description' => app()->getLocale() == 'ar' ? 'دع الفني يقيم المشكلة وسيتم خصم المبلغ من اجمالي الفاتورة':'Let the technician assess the problem and the amount will be deducted from the total bill',
            'price' => settings('preview_value') ? (double) settings('preview_value') : 0.00,
            'checked' => $order ? ($order->orderServices()->where('category_id',$category['id'])->where('preview_request',1)->exists()) : false,
            'count' => $order ? (int) $order->orderServices()->where('category_id',$category['id'])->where('preview_request',1)->sum('count') : 0,
        ];
        $services = $this->service->where('services.active',1)->where('category_id',$category['id'])->get();
        foreach ($services as $service){
            $data[] = [
                'id' => $service['id'],
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
                'checked' => $order ? ($order->orderServices()->where('service_id',$service['id'])->exists()) : false,
                'count' => $order ? ((int) $order->orderServices()->where('service_id',$service['id'])->sum('count')) : 0,
            ];
        }
        if($user_id != null){
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',$user_id)->where('live',0)->first();
        }else{
            $order = $this->orderRepo->where('uuid',$request['uuid'])->where('user_id',null)->where('live',0)->first();
        }
        return $this->successResponse([
            'services' => $data,
            'guarantee_days' => $parent['guarantee_days'],
            'tax' => $order ? $order['vat_amount'] : 0,
            'price' => $order ? $order->_price() : 0,
        ]);
    }
}
