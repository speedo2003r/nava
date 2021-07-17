<?php

namespace App\Http\Controllers\Api;
use App\Entities\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
use App\Http\Resources\services\ServiceCollection;
use App\Http\Resources\Settings\CategoryResource;
use App\Http\Resources\Users\ProviderCollection;
use App\Http\Resources\Users\SingleProviderResource;
use App\Http\Resources\Reviews\ReviewCollection;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\SliderRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    use ResponseTrait;

    public $sliderRepo, $userRepo, $categoryRepo;

    public function __construct(CategoryRepository $category,  UserRepository $user)
    {
        $this->userRepo = $user;
        $this->categoryRepo = $category;
    }
    public function searchSingleProvider(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'provider_id' => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if($validator->fails())
            return $this->ApiResponse('success',$validator->errors()->first());

        $provider_id = $request['provider_id'];
        if($request['filter_rate'] && $request['filter_price_max'] && $request['filter_price_min']){
            if($request['filter_rate'] == 1){
                $services = Service::query()->leftJoin('rating_services','rating_services.rateable_id','=','services.id')
                    ->select('services.*','rating_services.rate')
//                    ->where('store_name->ar','LIKE','%'.$request['key_search'].'%')
                    ->orderBy('rating_services.rate')
                    ->where('services.price','<=',$request['filter_price_max'])
                    ->where('services.price','>=',$request['filter_price_min'])
                    ->subexist()
                    ->whereHas('user',function ($user) use ($request,$provider_id){
                        $user->where('id',$provider_id);
                    })
                    ->paginate(10);
            }else{
                $services = Service::query()->leftJoin('rating_services','rating_services.rateable_id','=','services.id')
                    ->select('services.*','rating_services.rate')
//                    ->where('store_name->ar','LIKE','%'.$request['key_search'].'%')
                    ->orderBy('rating_services.rate','desc')
                    ->where('services.price','<=',$request['filter_price_max'])
                    ->where('services.price','>=',$request['filter_price_min'])
                    ->subexist()
                    ->whereHas('user',function ($user) use ($request,$provider_id){
                        $user->where('id',$provider_id);
                    })
                    ->paginate(10);
            }
        }else{
            $validator = Validator::make($request->all(),[
                'key_search' => 'required',
            ]);
            if($validator->fails())
                return $this->ApiResponse('success',$validator->errors()->first());

            if($request['lang'] == 'ar'){
                $services = Service::where('title->ar','LIKE','%'.$request['key_search'].'%')->subexist()->whereHas('user',function ($user) use ($request,$provider_id){
                        $user->where('id',$provider_id);
                    })->paginate(10);
            }else{
                $services = Service::where('title->en','LIKE','%'.$request['key_search'].'%')->subexist()->whereHas('user',function ($user) use ($request,$provider_id){
                        $user->where('id',$provider_id);
                    })->paginate(10);
            }
        }
        $collection = ServiceCollection::make($services);
        return $this->successResponse($collection);
    }
    public function searchProvider(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'lat' => 'required',
            'lng' => 'required',
//            'key_search' => 'required',
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
        ]);
        if($validator->fails())
            return $this->ApiResponse('success',$validator->errors()->first());

        $lat = $request['lat'];
        $lng = $request['lng'];
        if($request['filter_rate'] && $request['filter_price_max'] && $request['filter_price_min']){
            if($request['filter_rate'] == 1){
                $users = User::query()->leftJoin('rating_users','rating_users.rateable_id','=','users.id')
                    ->select('users.*','rating_users.rate')
//                    ->where('store_name->ar','LIKE','%'.$request['key_search'].'%')
                    ->where('users.category_id',$request['category_id'])
                    ->orderBy('rating_users.rate')
                    ->exist()
                    ->whereHas('services',function ($service) use ($request){
                        $service->where('services.price','<=',$request['filter_price_max']);
                        $service->where('services.price','>=',$request['filter_price_min']);
                    })
                    ->Olddistance(User::class,$lat,$lng)
                    ->where('user_type','provider')
                    ->paginate(10);
            }else{
                $users = User::query()->leftJoin('rating_users','rating_users.rateable_id','=','users.id')
                    ->select('users.*','rating_users.rate')
//                    ->where('store_name->en','LIKE','%'.$request['key_search'].'%')
                    ->where('users.category_id',$request['category_id'])
                    ->orderBy('rating_users.rate','desc')
                    ->exist()
                    ->whereHas('services',function ($service) use ($request){
                        $service->where('services.price','<=',$request['filter_price_max']);
                        $service->where('services.price','>=',$request['filter_price_min']);
                    })
                    ->Olddistance(User::class,$lat,$lng)
                    ->where('user_type','provider')
                    ->paginate(10);
            }
        }else{
            $validator = Validator::make($request->all(),[
                'key_search' => 'required',
            ]);
            if($validator->fails())
                return $this->ApiResponse('success',$validator->errors()->first());

            if($request['lang'] == 'ar'){
                $users = User::where('store_name->ar','LIKE','%'.$request['key_search'].'%')->where('category_id',$request['category_id'])->exist()->Olddistance(User::class,$lat,$lng)->where('user_type','provider')->paginate(10);
            }else{
                $users = User::where('store_name->en','LIKE','%'.$request['key_search'].'%')->where('category_id',$request['category_id'])->exist()->Olddistance(User::class,$lat,$lng)->where('user_type','provider')->paginate(10);
            }
        }
        $collection = ProviderCollection::make($users);
        return $this->successResponse($collection);
    }
    public function searchService(LangRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'lat' => 'required',
            'lng' => 'required',
//            'key_search' => 'required',
        ]);
        if($validator->fails())
            return $this->ApiResponse('success',$validator->errors()->first());

        $lat = $request['lat'];
        $lng = $request['lng'];
        if($request['filter_rate'] && $request['filter_price_max'] && $request['filter_price_min']){
            if($request['filter_rate'] == 1){
                $services = Service::query()->leftJoin('rating_services','rating_services.rateable_id','=','services.id')
                    ->select('services.*','rating_services.rate')
//                    ->where('store_name->ar','LIKE','%'.$request['key_search'].'%')
                    ->orderBy('rating_services.rate')
                    ->where('services.price','<=',$request['filter_price_max'])
                    ->where('services.price','>=',$request['filter_price_min'])
                    ->subexist()
                    ->whereHas('user',function ($user) use ($request,$lat,$lng){
                        $user->exist();
                        $user->Olddistance(User::class,$lat,$lng);
                        $user->where('user_type','provider');
                    })
                    ->paginate(10);
            }else{
                $services = Service::query()->leftJoin('rating_services','rating_services.rateable_id','=','services.id')
                    ->select('services.*','rating_services.rate')
//                    ->where('store_name->ar','LIKE','%'.$request['key_search'].'%')
                    ->orderBy('rating_services.rate','desc')
                    ->where('services.price','<=',$request['filter_price_max'])
                    ->where('services.price','>=',$request['filter_price_min'])
                    ->subexist()
                    ->whereHas('user',function ($user) use ($request,$lat,$lng){
                        $user->exist();
                        $user->Olddistance(User::class,$lat,$lng);
                        $user->where('user_type','provider');
                    })
                    ->paginate(10);
            }
        }else{
            $validator = Validator::make($request->all(),[
                'key_search' => 'required',
            ]);
            if($validator->fails())
                return $this->ApiResponse('success',$validator->errors()->first());

            if($request['lang'] == 'ar'){
                $services = Service::where('title->ar','LIKE','%'.$request['key_search'].'%')->subexist()->whereHas('user',function ($query) use ($lat,$lng){
                    $query->exist()->Olddistance(User::class,$lat,$lng)->where('user_type','provider');
                })->paginate(10);
            }else{
                $services = Service::where('title->en','LIKE','%'.$request['key_search'].'%')->subexist()->whereHas('user',function ($query) use ($lat,$lng){
                    $query->exist()->Olddistance(User::class,$lat,$lng)->where('user_type','provider');
                })->paginate(10);
            }
        }
        $collection = ServiceCollection::make($services);
        return $this->successResponse($collection);

    }
}
