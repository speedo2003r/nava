<?php

namespace App\Http\Controllers;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\City;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class AjaxController extends Controller
{
    use ResponseTrait;
    protected  $city;

    public function __construct(CountryRepository $country,CityRepository $city)
    {
        $this->city = $city;
        $this->country = $country;
    }

    public function getUser($id,Request $request)
    {
        if($request->ajax()){
            $user = User::find($id);

            return $this->ApiResponse('success','',$user);
        }
    }
    public function getCategories(Request $request)
    {
        if($request->ajax()){
            $category = Category::find($request['category']);
            if($category){
                return response()->json([
                    'data'=>$category->children,
                    'value'=>1,
                ]);
            }else{
                return response()->json([
                    'value'=>0,
                ]);
            }

        }
    }
    public function getservices(Request $request)
    {
        if($request->ajax()){
            $category = Category::find($request['category_id']);
            if($category){
                return response()->json([
                    'data'=>$category->services,
                    'value'=>1,
                ]);
            }

        }
    }
    public function getCities(Request $request)
    {
        if($request->ajax()){
            $country_id = $request['id'];
            $country = $this->country->find($country_id);
            $user = auth()->user();
            if($user['user_type'] == 'operation'){
                $cities = City::where('id',$user['city_id'])->get();
            }else{
                $cities = $country->cities;
            }
            return $this->successResponse($cities);
        }
    }
    public function getBranches(Request $request)
    {
        if($request->ajax()){
            $city_id = $request['city'];
            $city = City::find($city_id);
            $branches = $city->branches;
            return $this->successResponse($branches);
        }
    }
    public function getRegions(Request $request)
    {
        if($request->ajax()){
            $city_id = $request['id'];
            $city = $this->city->find($city_id);
            $regions = $city->Regions;
            return $this->successResponse($regions);
        }
    }
    public function getTechs(Request $request)
    {
        if($request->ajax()){
            $order = Order::find($request['id']);
            $category_id = $request['category_id'];
            $city_id = $order['city_id'];
            $city = $this->city->find($city_id);
            $region = $order->region;
            $branches = $region->branches()->pluck('branch_regions.branch_id')->toArray();
            $technicians = $city->technicians()->exist()->whereHas('branches',function ($branch) use ($branches){
                $branch->whereIn('branches.id',$branches);
            })->whereHas('categories',function ($query) use ($category_id){
                $query->where('user_categories.category_id',$category_id);
            })->get();
            $arr = [];
            foreach ($technicians as $technician){
                if($technician->progress_orders_count < settings('techOrderCount')){
                    $arr[] = $technician;
                }
            }
            return $this->successResponse($arr);
        }
    }

    public function getItems(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;
            $user = User::find($id);
            $services = $user->services;
            return response()->json($services);
        }
    }
    public function getSellers(Request $request)
    {
        $sellers = User::where('user_type','provider')->with('provider')->get();
        return response()->json($sellers);
    }
    public function changeAccepted(Request $request)
    {
        $item = User::find($request['id']);
        if ($item->accepted == 1){
            $item->accepted = 0;
        }else{
            $item->accepted = 1;
        }
        $item->save();
        return response()->json($item->accepted);
    }
}
