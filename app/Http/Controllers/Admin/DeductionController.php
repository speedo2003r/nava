<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AccountantDatatable;
use App\DataTables\ClientDatatable;
use App\DataTables\DeductionsDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accountant\Create;
use App\Http\Requests\Admin\Accountant\Update;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /***************************  get all providers  **************************/
    public function index(DeductionsDatatable $clientDatatable)
    {
        return $clientDatatable->render('admin.deductions.index');
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'accountant';
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $this->user->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $client = $this->user->find($id);
        if($request->has('image')){
            if($client['avatar'] != null || $client['avatar'] != '/default.png'){
                $this->deleteFile($client['avatar'],'users');
            }
            $request->request->add(['avatar'=>$this->uploadFile($request['image'],'users')]);
        }
        $this->user->update(array_filter($request->except('image')),$client['id']);
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
