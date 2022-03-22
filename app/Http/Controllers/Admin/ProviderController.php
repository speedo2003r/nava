<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProviderDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Provider\Create;
use App\Http\Requests\Admin\Provider\Update;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class ProviderController extends Controller
{
    use UploadTrait;
    protected $user,$city,$country, $role,$category;

    public function __construct(CategoryRepository $category,UserRepository $user,Role $role)
    {
        $this->user = $user;
        $this->category = $category;
        $this->role = $role;
    }

    /***************************  get all providers  **************************/
    public function index(ProviderDatatable $providerDatatable)
    {
        $roles  = $this->role->all();
        $categories  = $this->category->where('parent_id',null)->get();
        return $providerDatatable->render('admin.providers.index', compact('categories','roles'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'provider';
        $data['service_desc'] = [
            'ar' => $request['service_desc_ar'],
            'en' => $request['service_desc_en'],
        ];
        $data['store_name'] = [
            'ar' => $request['store_name_ar'],
            'en' => $request['store_name_en'],
        ];
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        if($request->has('banner')){
            $data['banner'] = $this->uploadFile($request['banner'],'banners');
        }
        $user = $this->user->create($data);
        $user->categories()->attach($request['categories']);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $provider = $this->user->find($id);
        $data = array_filter($request->except('image'));
        $data['service_desc'] = [
            'ar' => $request['service_desc_ar'],
            'en' => $request['service_desc_en'],
        ];
        $data['store_name'] = [
            'ar' => $request['store_name_ar'],
            'en' => $request['store_name_en'],
        ];
        if($request->has('image')){
            if($provider['avatar'] != null || $provider['avatar'] != '/default.png'){
                $this->deleteFile($provider['avatar'],'users');
            }
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        if($request->has('_banner')){
            if($provider['banner'] != null || $provider['banner'] != '/default.png'){
                $this->deleteFile($provider['banner'],'banners');
            }
            $data['banner'] = $this->uploadFile($request['_banner'],'banners');
        }
        $this->user->update($data,$provider['id']);
        $provider->categories()->sync($request['categories']);
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
                    $this->user->delete($d);
                }
            }
        }else {
            $role = $this->user->find($id);
            $this->user->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
