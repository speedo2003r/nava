<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomDatatable;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\Create;
use App\Http\Requests\Admin\Admin\UpdateProfile;
use App\Models\Role;
use App\Models\Room;
use App\Repositories\Interfaces\IRole;
use App\Repositories\Interfaces\IUser;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    use UploadTrait;
    protected $order,$userRepo, $roleRepo;

    public function __construct(OrderRepository $order,UserRepository $user,Role $role)
    {
        $this->userRepo = $user;
        $this->roleRepo = $role;
        $this->order = $order;
    }

    /***************************  get all admins  **************************/
    public function index(RoomDatatable $datatable)
    {
        $admins = $this->userRepo->findWhere(['user_type'=>'client']);
        return $datatable->render('admin.chat.index', compact('admins'));
    }


    public function OtherUsers(){
        return response()->json(['status'=>1,'message' => 'success','data' => User::where('id','!=',Auth::id())->where('user_type','provider')->get(['id','name','socket_id','online']) ]);
    }
    public function SaveMessage(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'     => 'max:500',
            'file'        => 'mimes:pdf,jpg,jpeg,png,gif|max:10000000',
            'room_id'     => 'required|exists:rooms,id',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) {
            return response()->json(['status' => 0, 'message' => $validate->errors()->first()]);
        }
        if (!$request->file && !$request->message) {
            return response()->json(['status' => 0, 'message' => 'no data to save']);
        }
        if (!Auth::check()) {
            $msg = trans('site.needLogin');
            session()->put('error', $msg);
            return response()->json(['status' => 2, 'message' => $msg]);
        }

        if($request->file){
            $filename       = $this->uploadFile($request->file, 'rooms/'. $request->room_id);
            $lastMessage    = saveMessage($request->room_id,$filename,Auth::id(),'file');
        }elseif($request->message){
            $lastMessage    = saveMessage($request->room_id,$request->message,Auth::id());
        }
        return response()->json(['status' => 1, 'message' => 'success', 'data' => $lastMessage]);
    }
    public function NewPrivateRoom($id){
        $currentUser = Auth::user();
        $order = Order::find($id);
        $otherUser = $order->user;
        $room = Room::where('order_id',$id)->first();
        if(!$room) {
            $room = creatPrivateRoom($currentUser->id, $otherUser->id);
        }
        $messages  = getRoomMessages($room->id, $currentUser->id);
        return response()->json(['status'=>1,'message' => 'success','room' =>$room,'messages'=>$messages ]);
    }
    public function ViewMessages($id){
        $order = $this->order->find($id);
        $existRoom = Room::where('order_id',$id)->first();
        if(!$existRoom){
            creatPrivateRoom(auth()->id(),$order['user_id'],$order['id']);
        }
        if(!in_array(auth()->id(),$existRoom->users()->pluck('users.id')->toArray())){
            joinRoom($existRoom['id'],auth()->id());
        }
        $user = $order->user;
        return view('admin.orders.chat',compact('order','user'));
    }
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $room = Room::find($d);
                    $room->delete();
                }
            }
        }else {
            $room = Room::find($id);
            $room->delete();
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    ############################# END CHAT WORK #############################




}
