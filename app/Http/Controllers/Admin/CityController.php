<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\Create;
use App\Http\Requests\Admin\City\Update;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\GovernorateRepository;
use App\Repositories\Interfaces\ICity;
use App\Repositories\Interfaces\ICountry;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $country,$city;

    public function __construct(CityRepository $city,CountryRepository $country)
    {
        $this->city = $city;
        $this->country = $country;
    }

    /***************************  get all providers  **************************/
    public function index()
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        return view('admin.cities.index', compact('countries','cities'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $this->city->create(['title'=>$translations,'country_id'=>$request['country_id']]);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $this->city->update(['title'=>$translations,'country_id'=>$request['country_id']],$id);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {

        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->city->delete($d);
                }
            }
        }else {
            $role = $this->city->find($id);
            $this->city->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
