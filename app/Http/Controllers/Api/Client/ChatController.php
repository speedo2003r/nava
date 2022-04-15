<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LangRequest;
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

    public function rooms(LangRequest $request)
    {
        $user = auth()->user();
        if(!$user){
            $this->ApiResponse('fail','user is undefined');
        }
        $rooms = $user->Rooms()->whereHas('order')->orderBy('created_at','desc')->get();
        return $this->successResponse(RoomResource::collection($rooms));
    }
    public function chat(LangRequest $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'order_id'     => 'required|exists:orders,id,deleted_at,NULL',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) {
            return response()->json(['status' => 0, 'message' => $validate->errors()->first()]);
        }
        $user = auth()->user();
        if(!$user){
            $this->ApiResponse('fail','user is undefined');
        }
        $roomMessages = [];
//        $room = $user->Rooms()->where('rooms.id',$request['room_id'])->first();
        $room = Room::where('rooms.order_id',$request['order_id'])->first();
        if($room){
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
//        return $this->respond($roomMessages);
        return $this->successResponse(new ChatCollection($roomMessages));
    }

    public function sendMessage(Request $request)
    {
        /** Validate Request **/
        $validate = Validator::make($request->all(), [
            'message'     => 'max:500',
            'file'        => 'mimes:pdf,jpg,jpeg,png,gif|max:10000000',
        ]);

        /** Send Error Massages **/
        if ($validate->fails()) {
            return response()->json(['status' => 0, 'message' => $validate->errors()->first()]);
        }
        if (!$request->file && !$request->message) {
            return response()->json(['status' => 0, 'message' => 'no data to save']);
        }
        $user = auth()->user();
        if(!$user){
            $this->ApiResponse('fail','user is undefined');
        }
        $room = $user->Rooms()->where('rooms.id',$request['room_id'])->first();

        if($request->file){
            $filename       = $this->uploadFile($request->file, 'rooms/'. $room['id']);
            $lastMessage    = saveMessage($room['id'],$filename,Auth::id(),'file');
        }elseif($request->message){
            $lastMessage    = saveMessage($room['id'],$request->message,Auth::id());
        }
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
