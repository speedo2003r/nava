<?php

namespace App\Http\Controllers\Api;

use App\Entities\Ad;
use App\Http\Requests\Api\Contact\ContactRequest;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Home\HomeResource;
use App\Http\Resources\Questions\QuestionResource;
use App\Http\Resources\services\AdCollection;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\services\ServiceResource;
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

class SettingController extends Controller
{
    use ResponseTrait;
    public $pageRepo,$order,$question,$city,$sliderRepo,$userRepo,$settingRepo,$socialRepo,$contactRepo,$categoryRepo;
    public function __construct(QuestionRepository $question,CityRepository $city,OrderRepository $order,SliderRepository $slider,PageRepository $page,UserRepository $user,SettingRepository $setting,SocialRepository $social,ContactUsRepository $contact,CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->pageRepo = $page;
        $this->sliderRepo = $slider;
        $this->settingRepo = $setting;
        $this->socialRepo = $social;
        $this->contactRepo = $contact;
        $this->categoryRepo = $category;
        $this->order = $order;
        $this->question = $question;
        $this->city = $city;
    }

    public function intros(LangRequest $request)
    {
        $lang = app()->getLocale();
        $data = [
            [
                'key' => 'intro1_'.$lang,
                'value' => settings('intro1_'.$lang),
            ],
            [
                'key' => 'intro2_'.$lang,
                'value' => settings('intro2_'.$lang),
            ],
            [
                'key' => 'intro3_'.$lang,
                'value' => settings('intro3_'.$lang),
            ],
        ];
        return $this->successResponse($data);
    }
    public function Home(LangRequest $request,User $user)
    {
        $validator = Validator::make($request->all(),[
            'device_type'   => 'required',
            'lat'       => 'required',
            'lng'       => 'required',
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $sliders = $this->sliderRepo->where(['active'=>1])->get();
        $categories = Category::where(['parent_id' => null])->whereHas('services',function ($query){
            $query->where('deleted_at',null);
            $query->where('status',1);
        })->get();
        $category = $this->categoryRepo->whereHas('services',function($query){
            $query->where('status',1);
        })->findWhere(['parent_id' => null])->first();
        if(count($category->children) > 0){
            $collection = SubCategoryCollection::make($category->children()->paginate(10));
        }else{
            $collection = ProviderCollection::make($category->providers()->paginate(10));
        }
        $categoryReso = CategoryResource::collection($categories);
        $categoryReso[] = new Collection([
            'id' => -1,
            'title' => app()->getLocale() == 'ar' ? 'العروض والاعلانات' : 'Offers and advertisements',
            'image' => dashboard_url('image.png'),
            'childExist' => false,
            'hasPledge' => false,
        ]);
        return $this->successResponse([
            'sliders' => SliderResource::collection($sliders),
            'categories' => $categoryReso,
            'collection' => $collection,
        ]);
    }
    public function selectHomeCategory(LangRequest $request,User $user)
    {
        $validator = Validator::make($request->all(),[
            'category_id'   => 'required',
            'lat'       => 'required',
            'lng'       => 'required',
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        if($request['category_id'] != -1){
            $exist = Category::find($request['category_id']);
            if(!$exist){
                if($validator->fails())
                    $msg = app()->getLocale() == 'ar' ? 'هذا القسم غير موجود' : 'this category is not exist';
                return $this->ApiResponse('fail',$msg);
            }
            $category = $this->categoryRepo->whereHas('services',function($query){
                $query->where('status',1);
            })->where(['parent_id' => null])->where('id',$request['category_id'])->first();

            if(count($category->children) > 0){
                $collection = SubCategoryCollection::make($category->children()->paginate(10));
            }else{
                $collection = ProviderCollection::make($category->providers()->paginate(10));
            }
            return $this->successResponse([
                'category' => CategoryResource::make($category),
                'collection' => $collection,
            ]);
        }else{
            $category = [
                'id' => -1,
                'title' => app()->getLocale() == 'ar' ? 'العروض والاعلانات' : 'Offers and advertisements',
                'image' => dashboard_url('image.png'),
                'childExist' => false,
                'hasPledge' => false,
            ];
            $ads = Ad::exist()->latest()->paginate(10);
            $collection = AdCollection::make($ads);
            return $this->successResponse([
                'category' => $category,
                'collection' => $collection,
            ]);
        }
    }
    public function About(Request $request)
    {
        return $this->successResponse(new pageResource($this->pageRepo->find(1)));
    }

    public function Policy(Request $request)
    {
        return $this->successResponse(new pageResource($this->pageRepo->find(2)));
    }

    public function SiteData(Request $request,Setting $setting)
    {
        $socialData = SocialResource::collection($this->socialRepo->all());
        $basicData  = [
            'phone' => settings('phone') ?? '',
            'phone2' => settings('phone2') ?? '',
        ];
        $siteData   = [
            'socialData'  => $socialData,
            'basicData'   => $basicData,
            'whatsapp'   => settings('whatsapp') ?? '',
            'isProduction'   => false,
            'mapZoom'   => 14,
        ];
        return $this->successResponse($siteData);
    }

    public function ContactMessage(ContactRequest $request)
    {
        $user = auth()->user();
        $data = array_filter($request->all());
        if($user != null){
            $data['user_id'] = $user['id'];
        }
        $this->contactRepo->create($data);
        return $this->successResponse();
    }
    public function complaints(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone' => 'required|digits_between:9,13',
            'email' => 'required|email',
            'title' => 'required',
            'message' => 'required',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $user = auth()->user();
        $data = array_filter($request->all());
        if($user != null){
            $data['user_id'] = $user['id'];
        }
        $data['type'] = 2;
        $this->contactRepo->create($data);
        return $this->successResponse();
    }

    public function questions(LangRequest $request)
    {
        $questions = $this->question->all();
        return $this->successResponse(QuestionResource::collection($questions));
    }
}
