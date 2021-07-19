<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Create;
use App\Http\Requests\Admin\Client\Update;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class TechnicianController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;
    protected $user, $country,$city;

    public function __construct(UserRepository $user,CountryRepository $country,CityRepository $city)
    {
        $this->user = $user;
        $this->country = $country;
        $this->city = $city;
    }

    /***************************  get all providers  **************************/
    public function index(ClientDatatable $clientDatatable)
    {
        $countries = $this->country->all();
        $cities = $this->city->all();
        return $clientDatatable->render('admin.clients.index', compact('cities','countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'client';
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

    public function sendnotifyuser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
        ]);
        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        if ($request->type == 'all') $users = User::where('user_type', $request['notify_type'])->get();
        else $users = User::whereId($request->id)->get();

        foreach ($users as $user) {
            $message = $request->message;
            #send FCM
            $this->send_notify($user->id, $message, $message);
        }
        return $this->ApiResponse('success', 'تم الارسال بنجاح');
    }

    public function changeStatus(Request $request)
    {
        if($request->ajax()){
            $provider = $this->user->find($request['id']);
            $provider['banned'] = !$provider['banned'];
            $provider->save();
            return $this->ApiResponse('success','',$provider['banned']);
        }
    }
    public function addToWallet(Request $request)
    {
        $provider = $this->user->find($request['id']);
        $provider['wallet'] += $request['wallet'];
        $provider->save();
        return back()->with('success','تم الاضافه بنجاح');
    }
}
