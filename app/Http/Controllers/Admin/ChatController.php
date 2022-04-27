<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomDatatable;
use App\Entities\Order;
use App\Enum\UserType;
use App\Events\createOrJoinRoom;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\Create;
use App\Http\Requests\Admin\Admin\UpdateProfile;
use App\Models\Message_notification;
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
use Illuminate\Support\Facades\Bus;
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
        $user_id = auth()->id();
        broadcast(new MessageSent($lastMessage,$user_id))->toOthers();
        $room = $lastMessage->room;
        $users = $room->Users()->where('users.id','!=',auth()->id())->get();
        $admins = User::where('user_type',UserType::ADMIN)->where('chat',1)->get();
        Bus::chain([
            new \App\Jobs\NotifyMsg($users,$lastMessage->Message['body']),
            new \App\Jobs\NotifyMsg($admins,$lastMessage->Message['body']),
        ])->dispatch();
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
        broadcast(new createOrJoinRoom($room))->toOthers();
        return response()->json(['status'=>1,'message' => 'success','room' =>$room,'messages'=>$messages ]);
    }
    public function ViewMessages($id){
        $order = $this->order->find($id);
        $existRoom = Room::where('order_id',$id)->first();
        if(!$existRoom){
            $existRoom = creatPrivateRoom(auth()->id(),$order['user_id'],$order['id']);
        }
        $existRoom->refresh();
        if(!in_array(auth()->id(),$existRoom->users()->pluck('users.id')->toArray())){
            joinRoom($existRoom['id'],auth()->id());
        }
        $user = $order->user;
        return view('admin.orders.chat',compact('existRoom','order','user'));
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

    public function messagesNotifications()
    {
        $messages = Message_notification::whereRaw('created_at IN (select MAX(created_at) FROM message_notifications GROUP BY room_id)')->where('is_sender',1)->latest()->paginate(10);
        Message_notification::where('is_seen',0)->update(['is_seen'=>1]);
        return view('admin.messagesNotifications.index',compact('messages'));
    }
    ############################# END CHAT WORK #############################




}
