<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ad\Create;
use App\Http\Requests\Admin\Ad\Update;
use App\Repositories\AdRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    use UploadTrait;
    use ResponseTrait;
    protected $adRepo,$specification,$userRepo;

    public function __construct(AdRepository $adRepo,UserRepository $userRepo)
    {
        $this->adRepo = $adRepo;
        $this->userRepo = $userRepo;
    }

    /***************************  get all categories  **************************/
    public function index(AdDatatable $ad)
    {
        $ads = $this->adRepo->all();
        $providers = $this->userRepo->where('user_type','provider')->get();
        return $ad->render('admin.ads.index', compact('ads','providers'));
    }
    /***************************  store category **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'ads');
        }
        if($request->has('file')){
            $data['file'] = $this->uploadFile($request['file'],'ads');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $data['desc'] = [
            'ar' =>$request['desc_ar'],
            'en' =>$request['desc_en'],
        ];
        $this->adRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update category  **************************/
    public function update(Update $request, $id)
    {
        $category = $this->adRepo->find($id);
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'ads');
        }
        if($request->has('file')){
            $data['file'] = $this->uploadFile($request['file'],'ads');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $data['desc'] = [
            'ar' =>$request['desc_ar'],
            'en' =>$request['desc_en'],
        ];
        $this->adRepo->update(array_filter($request->all()),$category['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete category  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $role = $this->adRepo->find($d);
                    $this->adRepo->delete($role['id']);
                }
            }
        }else {
            $role = $this->adRepo->find($id);
            $this->adRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function changeActive(Request $request)
    {
        if($request->ajax()){
            $ad = $this->adRepo->find($request['id']);
            $ad['active'] = !$ad['active'];
            $ad->save();
            return $this->ApiResponse('success','',$ad['active']);
        }
    }
}
