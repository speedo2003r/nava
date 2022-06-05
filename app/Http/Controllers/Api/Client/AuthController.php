<?php

namespace App\Http\Controllers\Api\Client;

use App;
use App\Entities\Order;
use App\Http\Requests\Api\register\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\profile\UpdateprofileRequest;
use App\Http\Requests\Api\login\LoginRequest;
use App\Http\Requests\Api\login\TechLoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\Entities\ReviewRate;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Http\Resources\Notifications\NotificationCollection;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\watchOldPassword;
use App\Repositories\UserRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\OrderRepository;
use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use App\Http\Requests\Api\LangRequest;
use App\Notifications\Api\DelegateRate;
use Pusher\Pusher;
use Tymon\JWTAuth\Facades\JWTAuth;

/** import */

class AuthController extends Controller
{
    use NotifyTrait;
    use SmsTrait;
    use ResponseTrait;
    use UploadTrait;
    public $userRepo,$deviceRepo,$order;
    public function __construct(OrderRepository $order,UserRepository $user,DeviceRepository $device)
    {
        $this->order     = $order;
        $this->userRepo     = $user;
        $this->deviceRepo   = $device;
    }
    /************************* Start Register ************************/
    public function UserRegister(UserRegisterRequest $request)
    {
        $user = $this->userRepo->create($request->all());
        if(empty($request['email']) || $request['email'] == ''){
            $user->email = 'user'.$user['id'].'@nava.com';
            $user->save();
        }

        $codeMessage = app()->getLocale()=='ar'?'الكود هو:':'Your code is:';
        $codeMessage = $codeMessage.' '.$user['v_code'];
        if (preg_match("~^0\d+$~", $user['phone'])) {
            sendSMS($user['phone'],$codeMessage);
        }
        else {
            sendSMS('0'.$user['phone'],$codeMessage);
        }
        $user->refresh();
        // save user and return token
        return $this->successResponse([
            'phone' => $user['phone']
        ]);
    }

    # active account after register - if ok logged in
    public function Activation(Request $request)
    {
        if(isset($request['replaced'])){
            $validate = Validator::make($request->all(), [
                'phone'  => 'required|exists:users,replace_phone|unique:users,phone,'. auth()->id().',id,deleted_at,NULL',
                'code'  => 'required',
                'lang'  => 'required',
            ]);
            if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
            $user = $this->userRepo->findWhere(['replace_phone' => $request->input('phone')])->first();
            if ($user->v_code === $request->input('code')) {
                //
                $replacePhone = $user['replace_phone'];
                $user->phone = $replacePhone;
                $user->replace_phone = null;
                $user->save();
                return $this->ApiResponse('success',  'تم تغيير الهاتف بنجاح');
            }
            return $this->ApiResponse('fail', 'الكود غير صحيح');
        }else{
            $user = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();
            $validate = Validator::make($request->all(), [
                'phone'  => 'required|exists:users,phone|unique:users,phone,'. $user['id'].',id,deleted_at,NULL',
                'uuid'        => 'required',
                'code'        => 'required|exists:users,v_code',
                'device_id'   => 'required|string',
                'device_type' => 'required:in,ios,android,web',
            ]);
            if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());

            if ($user->v_code === $request->input('code')) {
                $user->active = 1;
                $user->online = 1;
                $user->save();
                //
                if($user['user_type'] != App\Enum\UserType::CLIENT){
                    $device = $this->deviceRepo->findWhere(['uuid'=>$request['uuid'],'user_id'=>$user['id']])->first();
                    if($device){
                        $this->deviceRepo->delete($device['id']);
                    }
                    $this->deviceRepo->create(
                        array_merge($request->only(['device_id', 'device_type','uuid']), ['user_id' => $user->id])
                    );
                }
                if ((auth()->check() && $user->accepted == 0) || $user->accepted == 0) {
                    return response()->json([
                        'key' => 'not_accepted',
                        'value' => 4,
                        'msg' =>'تم تفعيل الهاتف برجاء الرجوع للاداره لتفعيل حسابك'
                    ]);
                }
                return $this->ApiResponse('success',  'تم تفعيل الهاتف بنجاح',[
                    'user' => userResource::make($user),
                    'token' => auth('api')->login($user)
                ]);
            }
            return $this->ApiResponse('fail', 'الكود غير صحيح');
        }

    }

    public function sendActiveCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone'   => 'required|exists:users,phone,deleted_at,NULL',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = $this->userRepo->findWhere(['phone'=>$request->input('phone')])->first();
        $this->userRepo->update(['v_code' => generateCode()],$user['id']);

        $codeMessage = app()->getLocale()=='ar'?'الكود هو:':'Your code is:';
        $codeMessage = $codeMessage.' '.$user['v_code'];
        if (preg_match("~^0\d+$~", $user['phone'])) {
            sendSMS($user['phone'],$codeMessage);
        }
        else {
            sendSMS('0'.$user['phone'],$codeMessage);
        }
        $user->refresh();
        return $this->successResponse([
            'code' => $user['v_code']
        ]);
    }
    public function checkActiveCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone'   => 'required|exists:users,phone,deleted_at,NULL',
            'code'   => 'required',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = $this->userRepo->findWhere(['phone'=>$request->input('phone')])->first();
        if($user['v_code'] != $request['code']){
            $msg = app()->getLocale() == 'ar' ? 'الكود غير صحيح' : 'verify code is wrong' ;
            return $this->ApiResponse('fail',$msg);
        }
        if($user['user_type'] == App\Enum\UserType::CLIENT){
            //      after login in client
            $validate = Validator::make($request->all(), [
                'uuid'   => 'required', // require if user type is client
                'device_id'   => 'required|max:200',
                'device_type' => 'required|in:android,ios,web',
            ]);
            if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
            $token = JWTAuth::fromUser($user);
            $device = $this->deviceRepo->findWhere(['uuid'=>$request['uuid'],'user_id'=>$user['id']])->first();
            if($device){
                $this->deviceRepo->delete($device['id']);
            }
            $this->deviceRepo->create(
                array_merge($request->only(['device_id', 'device_type','uuid']), ['user_id' => $user->id])
            );
            $this->userRepo->update([
                'online' => 1
            ],$user['id']);
            $order1 = $this->order->findWhere(['uuid'=>$request['uuid'],'user_id'=>null,'live'=>0])->first();
            $order2 = $this->order->findWhere(['uuid'=>$request['uuid'],'user_id'=>$user['id'],'live'=>0])->first();
            if($order2 && $order1){
                $order1->user_id = $user['id'];
                $order1->save();
                $order2->delete();
            }elseif($order1 && $order2 == null){
                $order1->user_id = $user['id'];
                $order1->save();
            }

            return $this->successResponse([
                'user' => userResource::make($user),
                'token' => $token
            ]);
        }
        return $this->successResponse();
    }
    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone'   => ['required',Rule::exists('users','phone')],
            'code'   => ['required'],
            'password'   => ['required'],
        ]);

        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();

        if ($user->v_code === $request->input('code')) {
            $this->userRepo->update($user,[
                'password'=>$request['password'],
            ]);

            return $this->ApiResponse('success',  'تم تغيير كلمة المرور بنجاح');
        }
        return $this->ApiResponse( 'fail', 'الكود غير صحيح');
    }

    /************************* End Register ************************/

    /************************   start basics *******************************/
    public function Login(LoginRequest $request)
    {
        if (!empty($request->input('phone'))) {
            $user = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();

            if ($user->banned == 1){
                return response()->json([
                    'key' => 'is_banned',
                    'value' => 2,
                    'msg' =>'لقد تم حظرك من قبل الاداره'
                ]);
            }

            if ($user->accepted == 0) {
                return response()->json([
                    'key' => 'not_accepted',
                    'value' => 4,
                    'msg' =>'برجاء الرجوع للاداره لتفعيل حسابك'
                ]);
            }
        }

        $exists = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();
        if(!$exists){
            return $this->ApiResponse('fail', 'برجاء التأكد من بيانات المستخدم');
        }
        $this->userRepo->update(['v_code' => generateCode()],$user['id']);

        $codeMessage = app()->getLocale()=='ar'?'الكود هو:':'Your code is:';
        $codeMessage = $codeMessage.' '.$user['v_code'];
        if (preg_match("~^0\d+$~", $user['phone'])) {
            sendSMS($user['phone'],$codeMessage);
        }
        else {
            sendSMS('0'.$user['phone'],$codeMessage);
        }
        $user->refresh();
        // save user and return token
        return $this->successResponse([
            'user' => userResource::make($user),
        ]);
    }
    public function techLogin(TechLoginRequest $request)
    {
        if (!empty($request->input('phone'))) {
            $user = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();

            if ($user->banned == 1){
                return response()->json([
                    'key' => 'is_banned',
                    'value' => 2,
                    'msg' =>'لقد تم حظرك من قبل الاداره'
                ]);
            }
            if ($user->active == 0){
                return response()->json([
                    'key' => 'not_active',
                    'value' => 3,
                    'msg' =>'يرجي تفعيل الهاتف قبل الاستكمال'
                ]);
            }
        }
        $isSamePassword = $this->userRepo->checkPassword($user,$request->input('password'));
        if (!$isSamePassword) {
            return $this->ApiResponse('fail', 'برجاء التأكد من بيانات المستخدم');
        }
        if ($user['user_type'] == 'client') {
            return $this->ApiResponse('fail', 'برجاء التأكد من بيانات المستخدم');
        }
        $exists = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();
        if(!$exists){
            return $this->ApiResponse('fail', 'برجاء التأكد من بيانات المستخدم');
        }
        $token = auth('api')->attempt(['email' => $user->email, 'password' => $request->input('password')]);
        $device = $this->deviceRepo->findWhere(['uuid'=>$request['uuid'],'user_id'=>$user['id']])->first();
        if($device){
            $this->deviceRepo->delete($device['id']);
        }
        $this->deviceRepo->create(
            array_merge($request->only(['device_id', 'device_type','uuid']), ['user_id' => $user->id])
        );
        $this->userRepo->update([
            'online' => 1
        ],$user['id']);
        // save user and return token
        return $this->successResponse([
            'user' => userResource::make($user),
            'token' => $token
        ]);
    }
    public function Logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id'   => 'required',
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $device = $this->deviceRepo->where(['device_id' => $request['device_id']])->first();

        if($device){
            $user = $device->user;
            if(!$device->user){
                return $this->ApiResponse('fail', trans('api.userUndefined'));
            }
            $this->userRepo->update([
                'online' => 0
            ],$user['id']);
            if($device){
                $this->deviceRepo->delete($device['id']);
            }
        }


        return $this->successResponse();
    }
    public function ForgetPasswordCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone,deleted_at,NULL',
            'v_code' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:100'],
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $user = $this->userRepo->findWhere(['phone'=>$request['phone']])->first();
        if ($user->v_code === $request->input('v_code')) {
            $this->userRepo->update([
                'password' => $request->input('password')
            ],$user['id']);
            return $this->ApiResponse( 'success',  'تم تغير كلمه السر',[
                'user' => userResource::make($user),
                'token' => auth('api')->login($user),
            ]);
        }
        return $this->ApiResponse( 'fail', 'الكود غير صحيح');
    }

    public function UpdatePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'old_password'  => ['required','min:6','max:255',new watchOldPassword()],
            'new_password'  => 'required|min:6|max:255',
        ]);
        if($request['old_password'] == $request['new_password']){
            $msg = app()->getLocale() == 'ar' ? 'كلمة المرور الجديده هي نفس كلمة المرور القديمه' : 'new password is equal old password';
            return $this->ApiResponse('fail', $msg);
        }
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = auth()->user();
        # update Password
        $this->userRepo->update([
            'password' => $request['new_password']
        ],$user['id']);
        return $this->ApiResponse('success', trans('api.passwordUpdated'));

    }
//
    public function EditLang(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'lang'  => 'required|in:ar,en',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = auth()->user();
        # update user
        $this->userRepo->update(['lang' => $request['lang']],$user['id']);
        \Illuminate\Support\Facades\App::setLocale($request['lang']);
        $msg = trans('api.Updated');
        return $this->ApiResponse('success', $msg);
    }

    # switch notification status for receive fcm or not
    public function NotificationStatus(Request $request)
    {
        $user = auth()->user();
        # update user
        return $this->successResponse(['notify' => $user->notify]);
    }
    # switch notification status for receive fcm or not
    public function NotificationToggle(Request $request)
    {
        $user = auth()->user();
        # update user
        $this->userRepo->update(['notify'  => !$user->notify],$user['id']);
        $user = $this->userRepo->find($user['id']);
        return $this->successResponse(['notify' => $user->notify]);
    }
    /************************   End basics *******************************/

    /************************   Start profile *******************************/

    public function ShowProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'lang'  => 'required|in:ar,en',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = auth()->user();
        return $this->successResponse(new UserResource($user));
    }


    public function UpdateProfile(UpdateprofileRequest $request)
    {
        $user = auth()->user();
        if($user['phone'] != $request['phone']){
            $user['replace_phone'] = $request['phone'];
            $user['v_code'] = generateCode();
            $user->save();
        }elseif($user['phone'] == $request['phone']){
            $user['replace_phone'] = null;
            $user->save();
        }
        # update user data
        if($request->has('_avatar')){
            $logo3 = $this->uploadFile($request['_avatar'],'users');
            $request->request->add(['avatar' => $logo3]);
        }
        $this->userRepo->update(array_filter($request->except('phone')),$user['id']);
        $data = $this->userRepo->find($user['id']);
        $replace_phone = $user['replace_phone'] != null ? true : false;
        return $this->successResponse(['user'=>userResource::make($data),'replace_phone' => $user['replace_phone'] ?? '','replaced' => $replace_phone]);
    }

    /************************   End profile *******************************/

    /*********************** Start notifications ***********************/
    public function Notifications(Request $request)
    {
        $user = auth()->user();
        # make all notifications seen = 1
        $UnreadNotifications = $user->notifications->where('read_at', null);
        foreach ($UnreadNotifications as $UnreadNotification){
            $UnreadNotification->markAsRead();
        }
        $data = new NotificationCollection($user->Notifications()->orderBy('notifications.id','desc')->paginate(20));
        return $this->successResponse($data);
    }
    public function UnreadNotifications(Request $request)
    {
        $user = auth()->user();
        $num  = $this->notifyRepo->findWhere(['to_id'=>$user['id'],'seen'=>0])->count();
        return $this->successResponse(['count' => $num]);
    }
    public function deleteNotification(LangRequest $request)
    {
        $this->notifyRepo->delete($request['id']);
        return $this->ApiResponse('success', trans('api.delete'));
    }
    public function Fakenotifications($id)
    {
        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'to_id'    => $id,
                'from_id'    => $id,
                'message_ar' => 'notification message ar',
                'message_en' => 'notification message en',
                'type'       => 'test',
            ];
        }
        Notification::insert($data);
        return 'fake notification added to user no ' . $id;
    }
    /*********************** End notifications ***********************/

    public function review(LangRequest $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id'  => 'required|exists:orders,id',
            'delegate_id'  => 'required|exists:users,id',
            'order_rate'  => 'required',
            'order_notes'  => 'required',
            'delegate_rate'  => 'required',
            'delegate_notes'  => 'required',
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = auth()->user();
        $exists = ReviewRate::where('user_id',$user['id'])->where('rateable_type',Order::class)->where('rateable_id',$request['order_id'])->exists();
        $exists2 = ReviewRate::where('user_id',$user['id'])->where('rateable_type',User::class)->where('rateable_id',$request['delegate_id'])->exists();
        if($exists && $exists2){
            return $this->ApiResponse('fail', app()->getLocale() == 'ar' ? 'لقد تم تقييم هذا الطلب من قبلك' : 'this order is already rated by you');
        }
        $rate = ReviewRate::create([
            'user_id' =>$user['id'],
            'rateable_id' => $request['order_id'],
            'rateable_type' => Order::class,
            'rate' => $request['order_rate'],
            'comment' => $request['order_notes'],
            'accept' => 1,
        ]);
        $order = $this->order->find($request['order_id']);
        $orderProducts = $order->orderProducts;
        foreach ($orderProducts as $orderProduct){
            App\Entities\RateItem::create([
                'item_id' => $orderProduct['item_id'],
                'rate_id' => $rate['id'],
            ]);
        }
        ReviewRate::create([
            'user_id' =>$user['id'],
            'rateable_id' => $request['delegate_id'],
            'rateable_type' => User::class,
            'rate' => $request['delegate_rate'],
            'comment' => $request['delegate_notes'],
            'accept' => 1,
        ]);
        $order = App\Entities\Order::find($request['order_id']);
        $user->notify(new DelegateRate($order));
        return $this->ApiResponse('success', app()->getLocale() == 'ar' ? 'تم تقييم هذا الطلب بنجاح' : 'this order is success rated');
    }
    /*********************** Start user wallet ***********************/
    public function Wallet(Request $request)
    {
        $user = auth()->user();
        return $this->successResponse([
            'user_id'=>$user['id'],
            'wallet' => $user['wallet']
        ]);
    }

    public function postMobilePusher(Request $request)
    {
        $user = auth()->user();
        $appId = env('PUSHER_APP_ID');
        $appKey = env('PUSHER_APP_KEY');
        $appSecret = env('PUSHER_APP_SECRET');
        $pusher = new Pusher($appId,$appKey,$appSecret);

        $socket_id = $request['socket_id'];
        $channel_name = $request['channel_name'];

        if(str_starts_with($channel_name,'private-')){
            $auth = $pusher->socketAuth($channel_name,$socket_id);
        }else{
            $user_id = $user->id;
            $user_info = [
                'firstName' => $user->name
            ];

            $auth = $pusher->presenceAuth( $channel_name, $socket_id, $user_id, $user_info );
        }
        return response()->json((object)[
            'auth' =>str_replace($appId.':','',json_decode($auth)->auth)
        ]);
    }
}
