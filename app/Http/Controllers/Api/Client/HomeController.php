<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Ad;
use App\Entities\Visit;
use App\Http\Requests\Api\Contact\ContactRequest;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Home\HomeResource;
use App\Http\Resources\Questions\QuestionResource;
use App\Http\Resources\services\AdCollection;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\services\ServiceResource;
use App\Http\Resources\Settings\CityResource;
use App\Http\Resources\Settings\SocialResource;
use App\Http\Resources\Settings\SliderResource;
use App\Http\Resources\Settings\SubCategoryCollection;
use App\Entities\Order;
use App\Entities\Setting;
use App\Entities\Slider;
use App\Http\Resources\Users\ProviderCollection;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\ContactUsRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PageRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SliderRepository;
use App\Repositories\SocialRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Entities\Category;
use App\Entities\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Settings\CategoryResource;
use App\Http\Resources\Settings\pageResource;

class HomeController extends Controller
{
    use ResponseTrait;
    public $pageRepo,$order,$city,$sliderRepo,$userRepo,$settingRepo,$socialRepo,$contactRepo,$categoryRepo;
    public function __construct(CityRepository $city,OrderRepository $order,SliderRepository $slider,PageRepository $page,UserRepository $user,SettingRepository $setting,SocialRepository $social,ContactUsRepository $contact,CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->sliderRepo = $slider;
        $this->categoryRepo = $category;
        $this->city = $city;
    }

    public function Home(Request $request,User $user)
    {
        $validator = Validator::make($request->all(),[
            'device_type'   => 'required',
            'city_id'       => 'nullable|exists:cities,id,deleted_at,NULL',
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        Visit::create([
            'device_type' => $request['device_type']
        ]);
        $categories = Category::where(['parent_id' => null])->exist()->get();
        return $this->successResponse(CategoryResource::collection($categories));
    }

    public function sliderHome(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'city_id'       => 'required|exists:cities,id,deleted_at,NULL',
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $sliders = $this->sliderRepo->where(function ($q) use ($request){
            $q->where('city_id',$request['city_id']);
            $q->orWhere('city_id',null);
        })->where(['active'=>1])->get();
        return $this->successResponse([
            'sliders' => SliderResource::collection($sliders),
        ]);
    }
}
