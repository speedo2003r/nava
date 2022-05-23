<?php

namespace App\Http\Controllers\Api\Client;

use App\Entities\Ad;
use App\Events\TestSent;
use App\Http\Requests\Api\Contact\ContactRequest;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\Home\HomeResource;
use App\Http\Resources\Questions\QuestionResource;
use App\Http\Resources\services\AdCollection;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\services\ServiceResource;
use App\Http\Resources\Settings\CityResource;
use App\Http\Resources\Settings\RegionResource;
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
use App\Repositories\RegionRepository;
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
    public $pageRepo,$order,$region,$city,$sliderRepo,$userRepo,$settingRepo,$socialRepo,$contactRepo,$categoryRepo;
    public function __construct(RegionRepository $region,CityRepository $city,OrderRepository $order,SliderRepository $slider,PageRepository $page,UserRepository $user,SettingRepository $setting,SocialRepository $social,ContactUsRepository $contact,CategoryRepository $category)
    {
        $this->userRepo = $user;
        $this->pageRepo = $page;
        $this->sliderRepo = $slider;
        $this->settingRepo = $setting;
        $this->socialRepo = $social;
        $this->contactRepo = $contact;
        $this->categoryRepo = $category;
        $this->order = $order;
        $this->city = $city;
        $this->region = $region;
    }

    public function intros(Request $request)
    {
        $lang = app()->getLocale();
        $data = [
            [
                'key' => 'intro1_' . $lang,
                'value' => settings('intro1_' . $lang),
            ],
            [
                'key' => 'intro2_' . $lang,
                'value' => settings('intro2_' . $lang),
            ],
            [
                'key' => 'intro3_' . $lang,
                'value' => settings('intro3_' . $lang),
            ],
        ];
        return $this->successResponse($data);
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

    public function cities(Request $request)
    {
        $cities = $this->city->all();
        return $this->successResponse(CityResource::collection($cities));
    }
    public function regions(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'city_id' => 'required|exists:cities,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        $regions = $this->region->where('city_id',$request['city_id'])->get();
        return $this->successResponse(RegionResource::collection($regions));
    }
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'search_key' => 'required'
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $categories = Category::where(['parent_id' => null])->whereHas('children',function ($q) use ($request){
            $q->whereHas('services',function ($query) use ($request){
                $query->where('title->'.$request['lang'],'like','%'.$request['search_key'].'%');
                $query->where('services.deleted_at',null);
                $query->where('status',1);
            });
        })->get();
        $categoryReso = CategoryResource::collection($categories);
        return $this->successResponse($categoryReso);
    }
    public function citySearch(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'search_key' => 'required'
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        $cities = $this->city->where('title->'.$request['lang'],'like','%'.$request['search_key'].'%')->get();
        return $this->successResponse(CityResource::collection($cities));
    }
    public function hoursRange(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'date' => 'sometimes'
        ]);
        if($validator->fails())
            return $this->ApiResponse('fail',$validator->errors()->first());

        if(isset($request['date']) && $request['date'] != null){
            $now = Carbon::now('Asia/Riyadh')->format('Y-m-d');
            $date = Carbon::parse($request['date'])->format('Y-m-d');
            if($date != $now){
                $seconds = 32400;
            }else{
                $time = Carbon::now('Asia/Riyadh')->addHour()->format('H:i');
                $parsed = date_parse($time);
                if($parsed['hour'].':'.($parsed['minute'] < 10 ? '0'.$parsed['minute'] : $parsed['minute']) < $parsed['hour'].':30'){
                    $minute = 30;
                    $hour = $parsed['hour'];
                }else{
                    $minute = 0;
                    $hour = $parsed['hour'] + 1;
                }
                if($hour < 9){
                    $hour = 9;
                }

                $seconds = $hour * 3600 + $minute * 60 + $parsed['second'];
            }
        }else{
            $time = Carbon::now('Asia/Riyadh')->addHour()->format('H:i');
//            $time = Carbon::parse('15:57')->format('H:i');
            $parsed = date_parse($time);
            if($parsed['hour'].':'.($parsed['minute'] < 10 ? '0'.$parsed['minute'] : $parsed['minute']) < $parsed['hour'].':30'){
                $minute = 30;
                $hour = $parsed['hour'];
            }else{
                $minute = 0;
                $hour = $parsed['hour'] + 1;
            }
//            dd(($parsed['hour'].':'.($parsed['minute'] < 10 ? '0'.$parsed['minute'] : $parsed['minute'])),$parsed['hour'].':30');

            if($hour < 9){
                $hour = 9;
            }
            $seconds = $hour * 3600 + $minute * 60 + $parsed['second'];
        }
        return $this->successResponse(hoursRange( $seconds, 75600, 60 * 30, 'h:i a' ) ?? []);
    }

    public function testSent($id)
    {
        return broadcast(new TestSent($id))->toOthers();
    }
}
