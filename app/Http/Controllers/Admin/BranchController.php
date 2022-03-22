<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BranchDatatable;
use App\Entities\Branch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\Create;
use App\Http\Requests\Admin\City\Update;
use App\Repositories\BranchRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\GovernorateRepository;
use App\Repositories\Interfaces\ICity;
use App\Repositories\Interfaces\ICountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    protected $country,$city,$branch,$category;

    public function __construct(CategoryRepository $category,BranchRepository $branch,CityRepository $city,CountryRepository $country)
    {
        $this->category = $category;
        $this->city = $city;
        $this->country = $country;
        $this->branch = $branch;
    }

    /***************************  get all providers  **************************/
    public function index(BranchDatatable $datatable,Branch $model)
    {
        return $datatable->render('admin.branches.index');
    }
    /***************************  get all providers  **************************/
    public function create()
    {
        $cities = $this->city->all();
        return view('admin.branches.create',compact('cities'));
    }
    /***************************  get all providers  **************************/
    public function edit($id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            $cities = $this->city->where('id',$user['city_id'])->get();
        }else{
            $cities = $this->city->all();
        }
        $branch = $this->branch->find($id);
        return view('admin.branches.edit',compact('cities','id','branch'));
    }


    /***************************  store provider **************************/
    public function store(Request $request)
    {
        $this->validate($request,[
            'title_ar' => 'required|max:191',
            'title_en' => 'required|max:191',
            'city_id' => 'required|exists:cities,id,deleted_at,NULL',
            'regions' => 'required|array',
        ]);
        $branches = Branch::whereHas('regions', function($q) use ($request) {
            $q->whereIn('regions.id', $request->get('regions'));
        })->get();

        if($branches->count()) {
            return redirect()->back()->withInput($request->input())->withErrors(['أحد المناطق المحددة يتم خدمتها بواسطة فرع اخر']);
        }
        $data = $request->all();
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $data['title'] = $translations;
        $branch = $this->branch->create($data);
        $branch->regions()->sync($request->get('regions'));
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title_ar' => 'required|max:191',
            'title_en' => 'required|max:191',
            'city_id' => 'required|exists:cities,id,deleted_at,NULL',
            'regions' => 'required|array',
        ]);
        $branch = $this->branch->find($id);

        $branches = Branch::whereHas('regions', function($q) use ($request) {
            $q->whereIn('regions.id', $request->get('regions'));
        })->where('id', '!=', $branch->id)->count();

        if($branches) {
            return redirect()->back()->withInput($request->input())->withErrors(['أحد المناطق المحددة يتم خدمتها بواسطة فرع اخر']);
        }
        $data = $request->all();
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $data['title'] = $translations;
        $this->branch->update($data,$id);
        $branch->regions()->sync($request->get('regions'));
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للحذف');
        }
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->branch->delete($d);
                }
            }
        }else {
            $role = $this->branch->find($id);
            $this->branch->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
