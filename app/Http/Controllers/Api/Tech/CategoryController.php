<?php

namespace App\Http\Controllers\Api\Tech;
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

    public function techOrderCategories(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id' => 'required|exists:orders,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $order = $this->orderRepo->find($request['order_id']);
        $category = $this->categoryRepo->find($order['category_id']);
        $subCategories = $category->children;
        return $this->successResponse(CategoryResource::collection($subCategories));
    }

    public function techOrderServices(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $data = [];
        $services = $this->service->where('category_id',$request['category_id'])->get();
        foreach ($services as $service){
            $data[] = [
                'id' => $service['id'],
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
            ];
        }
        return $this->successResponse($data);
    }

}