<?php

namespace App\Http\Controllers\Api\Tech;
use App\Enum\UserType;
use App\Events\createOrJoinRoom;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\ChatCollection;
use App\Http\Resources\Chat\RoomResource;
use App\Models\Room;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller{
    use ResponseTrait;
    use NotifyTrait;
    use UploadTrait;
    protected $userRepo;
    public function __construct(UserRepository $user)
    {
        $this->userRepo = $user;
    }

    public function chat(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'room_id'     => 'required|exists:rooms,id',
        ]);
        /** Send Error Massages **/
        if ($validate->fails()) {
            return $this->ApiResponse('fail',$validate->errors()->first());
        }
        $user = auth()->user();
        $roomMessages = [];
        $room = Room::where('rooms.id',$request['room_id'])->first();
        if($room){
            $exist = $room->Users()->where('room_id',$room['id'])->where('user_id',auth()->id())->exists();
            if($user['user_type'] != UserType::TECHNICIAN || !$exist){
                return $this->ApiResponse('fail','room id is undefined');
            }
            $roomMessages = $room->Messages()->with('Message')->where('user_id',$user['id'])->where('is_delete',0)->orderBy('created_at','desc')->paginate(20);
        }
        $countMessages = $room->Messages()->where('is_seen',0)->count();
        if($countMessages > 0){
            $Messages = $room->Messages()->where('is_seen',0)->get();
            foreach ($Messages as $message){
                $message->is_seen = 1;
                $message->save();
            }
        }
        broadcast(new createOrJoinRoom($room))->toOthers();
        return $this->successResponse([
            'room_id' => $room['id'],
            'messages' => new ChatCollection($roomMessages),
        ]);
    }

    public function sendMessage(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'     => 'max:500',
            'file'        => 'mimes:pdf,jpg,jpeg,png,gif|max:10000000',
            'room_id'     => 'required|exists:rooms,id',
        ]);
        /** Send Error Massages **/
        if ($validate->fails()) {
            return $this->ApiResponse('fail',$validate->errors()->first());
        }
        if (!$request->file && !$request->message) {
            return $this->ApiResponse('fail','no data to save');
        }
        $user = auth()->user();
        $room = Room::where('rooms.id',$request['room_id'])->first();
        if($room){
            $exist = $room->Users()->where('room_id',$room['id'])->where('user_id',auth()->id())->exists();
            if($user['user_type'] != UserType::TECHNICIAN || !$exist){
                return $this->ApiResponse('fail','room id is undefined');
            }
        }
        if($request->file){
            $filename       = $this->uploadFile($request->file, 'rooms/'. $room['id']);
            $lastMessage    = saveMessage($room['id'],$filename,Auth::id(),'file');
        }elseif($request->message){
            $lastMessage    = saveMessage($room['id'],$request->message,Auth::id());
        }
        broadcast(new MessageSent($lastMessage,$user['id']))->toOthers();
        $users = $room->Users()->where('users.id','!=',auth()->id())->where('user_type','!=',UserType::ADMIN)->get();
        $admins = $room->Users()->where('users.id','!=',auth()->id())->where('chat',1)->where('user_type',UserType::ADMIN)->get();
        Bus::chain([
            new \App\Jobs\NotifyMsg($users,$lastMessage->Message['body'],auth()->id()),
            new \App\Jobs\NotifyMsg($admins,$lastMessage->Message['body'],auth()->id()),
        ])->dispatch();
        $data = [
            'id' => $lastMessage['id'],
            'message_id' => $lastMessage['message_id'],
            'room_id' => $lastMessage['room_id'],
            'user_id' => $lastMessage['user_id'],
            'is_seen' => $lastMessage['is_seen'],
            'is_sender' => $lastMessage['is_sender'],
            'flagged' => $lastMessage['flagged'],
            'is_delete' => $lastMessage['is_delete'],
            'created_at' => date('Y-m-d H:i:s',strtotime($lastMessage['created_at'])),
            'updated_at' => date('Y-m-d H:i:s',strtotime($lastMessage['updated_at'])),
            'other_users' => $lastMessage['other_users'],
            'message' => [
                'id' => $lastMessage->message['id'],
                'body' => $lastMessage->message['body'],
                'room_id' => $lastMessage->message['room_id'],
                'user_id' => $lastMessage->message['user_id'],
                'type' => $lastMessage->message['type'],
                'created_at' => date('Y-m-d H:i:s',strtotime($lastMessage->message['created_at'])),
                'updated_at' => date('Y-m-d H:i:s',strtotime($lastMessage->message['updated_at'])),
            ],
        ];
        return $this->successResponse($data);
    }
}
