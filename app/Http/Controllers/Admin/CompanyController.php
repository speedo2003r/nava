<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\DataTables\CompanyDatatable;
use App\DataTables\TechnicianCompanyDatatable;
use App\DataTables\TechnicianDatatable;
use App\Entities\Income;
use App\Enum\IncomeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\Create;
use App\Http\Requests\Admin\Company\Update;
use App\Repositories\BranchRepository;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CountryRepository;
use App\Repositories\TechnicianRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $user, $country,$city,$company,$branch;

    public function __construct(BranchRepository $branch,CompanyRepository $company,UserRepository $user,CountryRepository $country,CityRepository $city)
    {
        $this->user = $user;
        $this->country = $country;
        $this->city = $city;
        $this->company = $company;
        $this->branch = $branch;
    }

    /***************************  get all providers  **************************/
    public function index(CompanyDatatable $clientDatatable)
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        return $clientDatatable->render('admin.companies.index', compact('cities','countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'company';
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $data['active'] = 1;
        $user = $this->user->create($data);
        $fillable = $user->getFillable();
        $request->request->add(['user_id'=>$user['id']]);
        $this->company->create($request->except($fillable));
        return redirect()->back()->with('success', '???? ?????????????? ??????????');
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
        $this->company->update($request->except($user->getFillable()),$user->technician['id']);
        return redirect()->back()->with('success', '???? ?????????????? ??????????');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','?????? ???????? ???????????????? ??????????');
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
        return redirect()->back()->with('success', '???? ?????????? ??????????');
    }

    public function technicians(TechnicianCompanyDatatable $table,$id)
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        return $table->render('admin.companies.technicians.index', compact('cities','countries','id'));
    }
    public function images($id)
    {
        $provider = $this->user->find($id);
        return view('admin.companies.images.index', compact('provider'));
    }
    public function storeImages(Request $request,$id)
    {
        $user = $this->user->find($id);
        if($request->has('_tax_certificate')){
            $this->deleteFile($user['tax_certificate'],'companies');
            $logo = $this->uploadFile($request['_tax_certificate'],'companies');
            $request->request->add(['tax_certificate'=>$logo]);
        }
        if($request->has('_commercial_image')){
            $this->deleteFile($user['commercial_image'],'companies');
            $logo = $this->uploadFile($request['_commercial_image'],'companies');
            $request->request->add(['commercial_image'=>$logo]);
        }
        $sellerRequests = $request->all();
        $company = $user->company;
        $this->company->update($sellerRequests,$company['id']);
        return redirect()->back()->with('success', '???? ?????????????? ??????????');
    }
    public function accounts($id)
    {
        $user = $this->user->find($id);
        $incomes = Income::where('user_id',$user['id'])->latest()->get();
        return view('admin.companies.accounts',compact('incomes','user'));
    }

}
