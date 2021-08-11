<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PartDatatable;
use App\Entities\Category;
use App\Entities\Service;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\BranchRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\FileRepository;
use Yajra\DataTables\Facades\DataTables;

class PartsController extends Controller
{
    use UploadTrait;
    protected $serviceRepo,$branch,$serviceType,$categoryRepo,$userRepo,$fileRepo,$langs;

    public function __construct(BranchRepository $branch,ServiceRepository $service,CategoryRepository $category,UserRepository $user,ImageRepository $file)
    {
        $this->serviceRepo = $service;
        $this->branch = $branch;
        $this->categoryRepo = $category;
        $this->userRepo = $user;
        $this->fileRepo = $file;
    }
    public function index(PartDatatable $datatable,$id)
    {
        $service = $this->serviceRepo->where('id',$id)->first();
        return $datatable->with(['id'=>$id])->render('admin.parts.index',compact('service'));
    }

    public function delete(Request $request)
    {
        $service = $this->serviceRepo->find($request->id);
        $this->serviceRepo->softDelete($service);
        return response()->json(true);
    }
    public function destroy(Request $request)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $service = Service::find($d);
                    if($service != null){
                        $service->delete();
                    }
                }
            }
        }else{
            $service = $this->serviceRepo->find($request->id);
            $this->serviceRepo->delete($request->id);
        }
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
    public function store(Request $request)
    {
        $data = $request->except('image');
        $translations = [];
        $desctranslations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
            $desctranslations[$locale['lang']] = $request['description_'.$locale['lang']];
        }
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'services');
        }
        $data['title'] = $translations;
        $data['description'] = $desctranslations;
        $service = $this->serviceRepo->create($data);

        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    public function update(Request $request,$id)
    {
        $service = $this->serviceRepo->find($id);
        $data = $request->except('image');
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'services');
        }
        $translations = [];
        $desctranslations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
            $desctranslations[$locale['lang']] = $request['description_'.$locale['lang']];
        }
        $data['title'] = $translations;
        $data['description'] = $desctranslations;
        $this->serviceRepo->update($data,$service['id']);

        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }


    public function changeStatus(Request $request)
    {
        $service = $this->serviceRepo->find($request->id);
        if ($service->active == 1){
            $service->active = 0;
        }else{
            $service->active = 1;
        }
        $service->save();
        return response()->json($service->active);
    }
    public function getFilterData(Request $request,Service $model)
    {
        $items = $model->query()
            ->select('services.id','services.image','services.active','services.title','services.category_id','services.title->'.app()->getLocale().' as services_title','services.description','services.created_at','services.price','services.type','categories.title->'.app()->getLocale().' as cat_title')
            ->leftJoin('categories','categories.id','=','services.category_id')
            ->latest();
        return DataTables::of($items)
            ->editColumn('id',function ($query){
                return '<label class="custom-control material-checkbox" style="margin: auto">
                            <input type="checkbox" class="material-control-input checkSingle" id="'.$query->id.'">
                            <span class="material-control-indicator"></span>
                        </label>';
            })
            ->addColumn('active',function ($query){
                return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                            <input type="checkbox" onchange="changeServiceActive('.$query->id.')" '.($query->active == 1 ? 'checked' : '') .' class="custom-control-input" id="customSwitch'.$query->id.'">
                            <label class="custom-control-label" id="status_label'.$query->id.'" for="customSwitch'.$query->id.'"></label>
                        </div>';
            })
            ->addColumn('url',function ($query){
                return 'admin.services.update';
            })
            ->addColumn('delete_url',function ($query){
                return 'admin.services.destroy';
            })
            ->editColumn('created_at',function ($query){
                return date('Y-m-d H:i:s',strtotime($query['created_at']));
            })
            ->addColumn('data',function ($query){
                return $query;
            })
            ->addColumn('target',function ($query){
                return 'editModel';
            })
            ->editColumn('type',function ($query){
                if($query['type'] == 'fixed'){
                    return awtTrans('ثابت');
                }elseif($query['type'] == 'hourly'){
                    return awtTrans('بالساعه');
                }elseif($query['type'] == 'pricing'){
                    return awtTrans('تقديري');
                }
            })
            ->filter(function ($query) use ($request) {
                if($request->search != null) {
                    $query->where('services.title->'.app()->getLocale(),'like','%'.$request->search['value'].'%');
                }
//                if($request->month != null) {
//                    $query->whereMonth('outlay_operations.created_at',date('m',strtotime($request->month)))
//                        ->whereYear('outlay_operations.created_at',date('Y',strtotime($request->month)));
//                }
                return $query;
            })
            ->addColumn('control','admin.partial.ControlEditDelService')
            ->rawColumns(['active','control','id'])->make(true);
    }
}
