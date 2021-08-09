<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RegionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\Create;
use App\Http\Requests\Admin\State\Update;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $country,$region;

    public function __construct(RegionRepository $region,CityRepository $city,CountryRepository $country)
    {
        $this->region = $region;
        $this->city = $city;
        $this->country = $country;
    }

    /***************************  get all providers  **************************/
    public function index(RegionDatatable $datatable)
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        return $datatable->render('admin.regions.index', compact('countries','cities'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $this->region->create(['title'=>$translations,'city_id'=>$request['city_id']]);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $this->region->update(['title'=>$translations,'city_id'=>$request['city_id']],$id);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {

        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->region->delete($d);
                }
            }
        }else {
            $role = $this->region->find($id);
            $this->region->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
