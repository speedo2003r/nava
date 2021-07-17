<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\Create;
use App\Http\Requests\Admin\Country\Update;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    protected $countryRepo;

    public function __construct(CountryRepository $country)
    {
        $this->countryRepo = $country;
    }

    /***************************  get all providers  **************************/
    public function index()
    {
        $countries = $this->countryRepo->all();
        return view('admin.countries.index', compact('countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $this->countryRepo->create(['title'=>$translations]);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $country = $this->countryRepo->find($id);
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $this->countryRepo->update(['title'=>$translations],$country['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->countryRepo->delete($d);
                }
            }
        }else {
            $role = $this->countryRepo->find($id);
            $this->countryRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
