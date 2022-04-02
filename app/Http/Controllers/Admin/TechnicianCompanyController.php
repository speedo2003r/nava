<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\DataTables\TechnicianCompanyDatatable;
use App\DataTables\TechnicianDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Technician\Create;
use App\Http\Requests\Admin\Technician\Update;
use App\Repositories\BranchRepository;
use App\Repositories\CategoryRepository;
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

class TechnicianCompanyController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $category,$user, $country,$city,$technician,$branch;

    public function __construct(CategoryRepository $category,BranchRepository $branch,TechnicianRepository $technician,UserRepository $user,CountryRepository $country,CityRepository $city)
    {
        $this->user = $user;
        $this->country = $country;
        $this->city = $city;
        $this->technician = $technician;
        $this->branch = $branch;
        $this->category = $category;
    }

    /***************************  get all providers  **************************/
    public function index(TechnicianCompanyDatatable $clientDatatable,$id)
    {
        $categories = $this->category->where('parent_id',null)->get();
        $countries = $this->country->all();
        $cities = $this->city->all();
        return $clientDatatable->with('id',$id)->render('admin.companies.technicians.index', compact('categories','id','cities','countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request,$id)
    {
        $company = $this->user->find($id);
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'technician';
        $data['company_id']  = $company['id'];
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
