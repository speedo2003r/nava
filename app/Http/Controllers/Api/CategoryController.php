<?php

namespace App\Http\Controllers\Api;
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
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller{

    use ResponseTrait;
    public $userRepo,$categoryRepo,$banner;
    public function __construct(BannerRepository $banner,UserRepository $user,CategoryRepository $category)
    {
        $this->banner = $banner;
        $this->userRepo = $user;
        $this->categoryRepo = $category;
    }

    public function SingleCategory(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'subcategory_id' => 'required|exists:categories,id',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $category = $this->categoryRepo->find($request['subcategory_id']);
        $banners = $category->banners()->where('active',1)->get();
        $subcategory_id = $request['subcategory_id'];
        $providers = $this->userRepo->whereHas('categories',function ($cat) use ($subcategory_id){
            $cat->where('categories.id',$subcategory_id);
        })->paginate(10);

        return $this->successResponse([
            'banners' => BannerResource::collection($banners),
            'providers' => ProviderCollection::make($providers),
        ]);
    }
}
