<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\DataTables\TechnicianDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Technician\Create;
use App\Http\Requests\Admin\Technician\Update;
use App\Repositories\BranchRepository;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\TechnicianRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $user, $country,$city,$technician,$branch;

    public function __construct(BranchRepository $branch,TechnicianRepository $technician,UserRepository $user,CountryRepository $country,CityRepository $city)
    {
        $this->user = $user;
        $this->country = $country;
        $this->city = $city;
        $this->technician = $technician;
        $this->branch = $branch;
    }

    /***************************  get all providers  **************************/
    public function index(TechnicianDatatable $clientDatatable)
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        $branches = $this->branch->all();
        return $clientDatatable->render('admin.technicians.index', compact('branches','cities','countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'technician';
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $user = $this->user->create($data);
        $fillable = $user->getFillable();
        $request->request->add(['user_id'=>$user['id']]);
        $this->technician->create($request->except($fillable));
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $user = $this->user->find($id);
        if($request->has('image')){
            if($user['avatar'] != null || $user['avatar'] != '/default.png'){
                $this->deleteFile($user['avatar'],'users');
            }
            $request->request->add(['avatar'=>$this->uploadFile($request['image'],'users')]);
        }
        $this->user->update(array_filter($request->except('image')),$user['id']);
        $this->technician->update($request->except($user->getFillable()),$user->technician['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
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
