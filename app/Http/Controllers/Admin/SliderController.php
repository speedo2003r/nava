<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDatatable;
use App\Entities\Ad;
use App\Entities\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\Create;
use App\Http\Requests\Admin\Slider\Update;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\SliderRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ResponseTrait;
    use UploadTrait;
    protected $sliderRepo,$city,$countryRepo,$user;

    public function __construct(protected CategoryRepository $category,CityRepository $city,UserRepository $user,SliderRepository $slider,CountryRepository $country)
    {
        $this->sliderRepo = $slider;
        $this->countryRepo = $country;
        $this->user = $user;
        $this->city = $city;
    }

    /***************************  get all providers  **************************/
    public function index(SliderDatatable $sliderDatatable)
    {
        $categories = $this->category->where('parent_id',null)->get();
        $cities = $this->city->all();
        return $sliderDatatable->render('admin.sliders.index',compact('cities','categories'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = $request->all();
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'sliders');
        }
        $this->sliderRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $slider = $this->sliderRepo->find($id);
        $data = $request->all();
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'sliders');
        }
        $this->sliderRepo->update(array_filter($data),$slider['id']);
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
                    $this->sliderRepo->delete($d);
                }
            }
        }else {
            $role = $this->sliderRepo->find($id);
            $this->sliderRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function changeActive(Request $request)
    {
        if($request->ajax()){
            $slider = $this->sliderRepo->find($request['id']);
            $slider['active'] = !$slider['active'];
            $slider->save();
            return $this->successResponse($slider['active']);
        }
    }
}
