<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\Create;
use App\Http\Requests\Admin\Admin\Update;
use App\Http\Requests\Admin\Admin\UpdateProfile;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\GovernorateRepository;
use App\Repositories\UserRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DB;

class AdminController extends Controller
{
    use UploadTrait;
    protected $city,$userRepo, $roleRepo,$country;

    public function __construct(CityRepository $city,UserRepository $user,CountryRepository $country,Role $role)
    {
        $this->userRepo = $user;
        $this->roleRepo = $role;
        $this->city = $city;
        $this->country = $country;
    }

    /***************************  get all admins  **************************/
    public function index()
    {
        $cities = $this->city->all();
        $admins = $this->userRepo->whereIn('user_type',['admin','operation'])->get();
        $roles  = $this->roleRepo->all();
        $countries  = $this->country->all();
        return view('admin.admins.index', compact('cities','countries','admins','roles'));
    }


    /***************************  store admin **************************/
    public function store(Create $request)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للاضافه');
        }
        if($request['user_type'] == 'operation'){
            $this->validate($request,[
                'city_id' => 'required|exists:cities,id,deleted_at,NULL'
            ]);
        }
        $data = array_filter($request->except('image'));
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $this->userRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  edit admin  **************************/
    public function edit($id)
    {
        $admin = $this->userRepo->find($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /***************************  update admin  **************************/
    public function update(Update $request, $id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للتحديث');
        }
        if($request['user_type'] == 'operation'){
            $this->validate($request,[
                'city_id' => 'required|exists:cities,id,deleted_at,NULL'
            ]);
        }
        $admin = $this->userRepo->find($id);
        if($request->has('image')){
            $this->deleteFile($admin['avatar'],'users');
            $request->request->add(['avatar'=>$this->uploadFile($request['image'],'users')]);
        }
        $this->userRepo->update(array_filter($request->except('image')),$admin['id']);
        return redirect()->back()->with('success', 'تم تحديث بنجاح');
    }

    /***************************  delete admin  **************************/
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
                    $this->userRepo->delete($d);
                }
            }
        }else {
            $role = $this->userRepo->find($id);
            $this->userRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    /***************************  update profile  **************************/
//    public function updateProfile(UpdateProfile $request,$id)
//    {
//        $admin = $this->userRepo->findOrFail($id);
//        if($request->has('image')) {
//            $this->deleteFile($admin['avatar'], 'users');
//            $request->request->add(['avatar' => $this->uploadFile($request['image'], 'users')]);
//        }
//        $this->userRepo->update(array_filter($request->except('image')),$admin);
//        return redirect()->back()->with('success', 'updated successfully');
//    }
}
