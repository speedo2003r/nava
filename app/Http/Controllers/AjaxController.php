<?php

namespace App\Http\Controllers;

use App\Entities\Branch;
use App\Entities\Category;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class AjaxController extends Controller
{
    use ResponseTrait;
    protected $governorate,$city;

    public function __construct(CityRepository $city)
    {
        $this->city = $city;
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
    public function getCities(Request $request)
    {
        if($request->ajax()){
            $governorate_id = $request['id'];
            $governorate = $this->governorate->find($governorate_id);
            $cities = $governorate->cities;
            return $this->successResponse($cities);
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

    public function getItems(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;
            $user = User::find($id);
            $services = $user->services;
            return response()->json($services);
        }
    }
    public function getAds(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;
            $user = User::find($id);
            $ads = $user->ads()->exist()->get();
            return response()->json($ads);
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
