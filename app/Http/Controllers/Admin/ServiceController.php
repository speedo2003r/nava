<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Category;
use App\Entities\Service;
use App\Http\Controllers\Controller;
use App\Models\User;
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

class ServiceController extends Controller
{
    use UploadTrait;
    protected $serviceRepo,$serviceType,$categoryRepo,$userRepo,$fileRepo,$langs;

    public function __construct(ServiceRepository $service,CategoryRepository $category,UserRepository $user,ImageRepository $file)
    {
        $this->serviceRepo = $service;
        $this->categoryRepo = $category;
        $this->userRepo = $user;
        $this->fileRepo = $file;
        $this->langs = [
            'ar' => 'arabic',
            'en' => 'english',
        ];
    }
    public function index()
    {
        return view('admin.service.index');
    }

    public function create()
    {
        $langs = $this->langs;
        $categories = $this->categoryRepo->findWhere(['parent_id'=>null]);
        $services = $this->serviceRepo->paginate(8);
        $sellers = $this->userRepo->findWhere(['user_type'=>'provider']);
        return view('admin.service.addService', compact('services', 'categories', 'langs', 'sellers'));
    }
    public function edit($id)
    {
        $langs = $this->langs;
        $categories = $this->categoryRepo->findWhere(['parent_id'=>null]);
        $services = Service::whereId($id)->with('files')->orderBy('id', 'desc')->get();
        $sellers = $services->first()->user()->get();
        return view('admin.service.addService', compact('id','services',  'categories', 'langs', 'sellers'));
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
            $this->serviceRepo->softDelete($service);
        }
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
    public function addFile(Request $request)
    {
        $service = $this->serviceRepo->find($request->id);
        $image = $this->uploadFile($request['file'],'services');
        $service->update([
            'image' => $image
        ]);
        return response()->json(['image'=>dashboard_url('storage/images/services/'.$image)]);
    }
    public function changeMain(Request $request)
    {
        $file = $this->fileRepo->find($request->id);
        $service = $file->service;
        $service->files->each(function ($value,$index) use ($request){
            if($request['id'] != $value['id']){
                $value->main = 0;
                $value->save();
            }else{
                $value->main = 1;
                $value->save();
            }
        });
        return response()->json(dashboard_url('storage/images/services/'. $file['image']));
    }

    public function store(Request $request)
    {
        if ($request->id == null) {
            $data = $request->except('image');
            $data['title'] = [
                'ar' => $request['title_ar'],
                'en' => $request['title_en'],
            ];
            $category = Category::find($request['subcategory_id']);
            $data['category_id'] = $category->parent['id'];
            $service = $this->serviceRepo->create($data);
            $service = $this->serviceRepo->find($service['id']);
            $request->request->add(['service_id' => $service['id']]);
        } else {
            $service = $this->serviceRepo->find($request->id);
            $data = $request->except('image');
            $data['title'] = [
                'ar' => $request['title_ar'],
                'en' => $request['title_en'],
            ];
            $data['sub_category_id'] = $request['subcategory_id'];
            $data['category_id'] = $request['category_id'];
            $this->serviceRepo->update($data,$service['id']);
        }
        return response()->json($service);
    }


    public function delimage(Request $request)
    {
        $id = $request->id;
        $image = $this->fileRepo->find($id);
        $image_path = $image['image']; // Value is not URL but directory file path;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $this->fileRepo->softDelete($image);
        return response()->json(true);
    }


    public function update(Request $request,$id)
    {
        $service = $this->serviceRepo->find($id);
        $data = array_filter($request->all());
        $data['description'] = [
            'ar' => $request['description_ar'],
            'en' => $request['description_en'],
        ];
        $this->serviceRepo->update($data,$service['id']);
        return response()->json($service);
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
    public function getSellerCategories(Request $request)
    {
        $seller = $this->userRepo->find($request['id']);
        $allcategories = $seller->categories;
        return response()->json(['categories'=>$allcategories]);
    }
    public function getFilterData(Request $request,Service $model)
    {
        $items = $model->query()->latest();
        return DataTables::of($items)
            ->editColumn('id',function ($query){
                return '<label class="custom-control material-checkbox" style="margin: auto">
                            <input type="checkbox" class="material-control-input checkSingle" id="'.$query->id.'">
                            <span class="material-control-indicator"></span>
                        </label>';
            })
            ->addColumn('url',function ($query){
                return 'admin.services.edit';
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
            ->filter(function ($query) use ($request) {
                if($request->search != null) {
                    $query->where('services.name','like','%'.$request->search['value'].'%');
                }
//                if($request->month != null) {
//                    $query->whereMonth('outlay_operations.created_at',date('m',strtotime($request->month)))
//                        ->whereYear('outlay_operations.created_at',date('Y',strtotime($request->month)));
//                }
                return $query;
            })
            ->addColumn('control','admin.partial.ControlPag')
            ->rawColumns(['status','control','id'])->make(true);
    }
}
