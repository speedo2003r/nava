<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDatatable;
use App\Entities\Ad;
use App\Entities\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\Create;
use App\Http\Requests\Admin\Slider\Update;
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

    public function __construct(CityRepository $city,UserRepository $user,SliderRepository $slider,CountryRepository $country)
    {
        $this->sliderRepo = $slider;
        $this->countryRepo = $country;
        $this->user = $user;
        $this->city = $city;
    }

    /***************************  get all providers  **************************/
    public function index(SliderDatatable $sliderDatatable)
    {
        $sellers = $this->user->findWhere(['user_type'=>'provider']);
        return $sliderDatatable->render('admin.sliders.index',compact('sellers'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        if($data['type'] == 'service'){
            if($data['service_id'] == null){
                return redirect()->back()->with('danger', 'حقل الخدمات مطلوب');
            }
            $data['itemable_id'] = $data['service_id'];
            $data['itemable_type'] = Service::class;
        }
        if($data['type'] == 'ad'){
            if($data['ad_id'] == null){
                return redirect()->back()->with('danger', 'حقل الاعلانات مطلوب');
            }
            $data['itemable_id'] = $data['ad_id'];
            $data['itemable_type'] = Ad::class;
        }
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'sliders');
        }
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $data['title'] = $translations;
        $this->sliderRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $slider = $this->sliderRepo->find($id);
        $data = array_filter($request->all());
        if($data['type'] == 'service'){
            if($data['service_id'] == null){
                return redirect()->back()->with('danger', 'حقل الخدمات مطلوب');
            }
            $data['itemable_id'] = $data['service_id'];
            $data['itemable_type'] = Service::class;
        }
        if($data['type'] == 'ad'){
            if($data['ad_id'] == null){
                return redirect()->back()->with('danger', 'حقل الاعلانات مطلوب');
            }
            $data['itemable_id'] = $data['ad_id'];
            $data['itemable_type'] = Ad::class;
        }
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'sliders');
        }
        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $data['title'] = $translations;
        $this->sliderRepo->update(array_filter($data),$slider['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
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
