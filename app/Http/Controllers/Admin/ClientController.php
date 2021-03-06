<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\Entities\Order;
use App\Enum\WalletOperationType;
use App\Enum\WalletType;
use App\Events\createOrJoinRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Create;
use App\Http\Requests\Admin\Client\Update;
use App\Jobs\NotifyFcm;
use App\Models\Room;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
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
        return $clientDatatable->render('admin.clients.index', compact('countries'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->except('image'));
        $data['user_type']  = 'client';
        if($request->has('image')){
            $data['avatar'] = $this->uploadFile($request['image'],'users');
        }
        $data['active'] = 1;
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

    public function sendnotifyuser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
        ]);
        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        if ($request->id == 0) {
            $users = User::where('notify', 1)->where('user_type', 'client')->get();
        }else {
            $users = User::where('notify', 1)->whereId($request->id)->get();
        }
        $message = $request->message;
        $job = (new NotifyFcm($users,$message));
        dispatch($job);

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
    public function changeNotify(Request $request)
    {
        if($request->ajax()){
            $provider = $this->user->find($request['id']);
            $provider['notify'] = !$provider['notify'];
            $provider->save();
            return $this->ApiResponse('success','',$provider['notify']);
        }
    }
    public function addToWallet(Request $request)
    {
        $provider = $this->user->find($request['id']);
        $provider->wallets()->create([
            'amount' => $request['wallet'],
            'type' => WalletType::DEPOSIT,
            'created_by'=>auth()->id(),
            'operation_type'=>WalletOperationType::DEPOSIT,
        ]);
        return back()->with('success','تم الاضافه بنجاح');
    }

    public function chat($id)
    {
        $existRoom = Room::where(function ($in) use ($id){
            $in->where('other_user_id',$id);
        })->where('order_id',null)->first();
        if(!$existRoom){
            $existRoom = creatPrivateRoom(auth()->id(),$id);
        }
        $existRoom->refresh();
        if(!in_array(auth()->id(),$existRoom->users()->pluck('users.id')->toArray())){
            joinRoom($existRoom['id'],auth()->id());
        }
        $user = $this->user->find($id);
        return view('admin.clients.chat',compact('existRoom','user'));
    }

    public function NewPrivateRoom($id){
        $currentUser = Auth::user();
        $otherUser = User::find($id);
        $room = Room::where(function ($in) use ($id){
            $in->where('user_id',$id)->orWhere('other_user_id',$id);
        })->where('order_id',null)->first();
        if(!$room) {
            $room = creatPrivateRoom($currentUser->id, $otherUser->id);
        }
        $messages  = getRoomMessages($room->id, $currentUser->id);
        broadcast(new createOrJoinRoom($room))->toOthers();
        return response()->json(['status'=>1,'message' => 'success','room' =>$room,'messages'=>$messages ]);
    }
}
