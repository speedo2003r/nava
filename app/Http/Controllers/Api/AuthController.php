<?php

namespace App\Http\Controllers\Api;

use App;
use App\Entities\Order;
use App\Http\Requests\Api\register\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\profile\UpdateprofileRequest;
use App\Http\Requests\Api\login\LoginRequest;
use App\Entities\Favourite;
use App\Http\Resources\Notifications\NotificationResource;
use App\Http\Resources\Users\AddressResource;
use App\Http\Resources\Users\UserResource;
use App\Entities\Notification;
use App\Entities\OrderProduct;
use App\Models\User;
use App\Entities\ReviewRate;
use App\Entities\UserAddress;
use App\Entities\WalletPay;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Http\Resources\Notifications\NotificationCollection;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\register\ActivationRequest;
use App\Http\Requests\Api\Address\Address as AddressRequest;
use Illuminate\Validation\Rule;
use App\Rules\watchOldPassword;
use App\Repositories\UserRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use App\Http\Requests\Api\LangRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

/** import */

class AuthController extends Controller
{
    use NotifyTrait;
    use SmsTrait;
    use ResponseTrait;
    use UploadTrait;
    public $userRepo,$deviceRepo,$notifyRepo,$order;
    public function __construct(OrderRepository $order,UserRepository $user,DeviceRepository $device,NotificationRepository $notify)
    {
        $this->order     = $order;
        $this->userRepo     = $user;
        $this->deviceRepo   = $device;
        $this->notifyRepo   = $notify;
    }
    /************************* Start Register ************************/
    public function UserRegister(UserRegisterRequest $request)
    {
        $user = $this->userRepo->create($request->all());
        //
        $this->deviceRepo->create(
            array_merge($request->only(['device_id', 'device_type']), ['user_id' => $user->id])
        );
//        $this->sendSms($user['phone'],$user['v_code']);
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
                'code'        => 'required|exists:users,v_code',
                'device_id'   => 'required',
                'device_type' => 'required:in,ios,android,web',
            ]);
            if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());

            if ($user->v_code === $request->input('code')) {
                $user->active = 1;
                $user->online = 1;
                $user->save();
                //
                $device = $this->deviceRepo->findWhere(['uuid'=>$request['uuid'],'user_id'=>$user['id']])->first();
                if($device){
                    $this->deviceRepo->delete($device['id']);
                }
                $this->deviceRepo->create(
                    array_merge($request->only(['device_id', 'device_type','uuid']), ['user_id' => $user->id])
                );

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
            'phone'   => ['required',Rule::exists('users','phone')],
        ]);
        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = $this->userRepo->findWhere(['phone'=>$request->input('phone')])->first();
        $this->userRepo->update(['v_code' => generateCode()],$user['id']);

//        sendSMS($user['phone'],$user['v_code']);
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
    public function validateRegister(LangRequest $request){
        $validator = Validator::make($request->all(),[
            'phone'=>'required|numeric|digits:10|unique:users,phone,NULL,id,deleted_at,NULL',
            'email'=>'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        ]);
        if($validator->fails()){
            return $this->ApiResponse('fail',$validator->errors()->first());
        }
        return $this->successResponse();
    }
    public function ResendActiveCode(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'phone'   => ['required',Rule::exists('users','phone')],
        ]);

        if ($validate->fails()) return $this->ApiResponse('fail', $validate->errors()->first());
        $user = $this->userRepo->findWhere(['phone' => $request->input('phone')])->first();
        $this->userRepo->update(['v_code' => generateCode()],$user['id']);

//        $this->sendSms($user['phone'],$user['v_code']);
        return $this->successResponse();
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
            if ($user->active == 0){
                return response()->json([
                    'key' => 'not_active',
                    'value' => 3,
                    'msg' =>'يرجي تفعيل الهاتف قبل الاستكمال'
                ]);
            }

            if ($user->accepted == 0) {
                return response()->json([
                    'key' => 'not_accepted',
                    'value' => 4,
                    'msg' =>'برجاء الرجوع للاداره لتفعيل حسابك'
                ]);
            }
        } elseif (!empty($request->input('email'))) {
            $user = $this->userRepo->findWhere(['email' => $request->input('email')])->first();
        }
        $isSamePassword = $this->userRepo->checkPassword($user,$request->input('password'));
        if (!$isSamePassword) {
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
            'device_id'   => ['required', 'max:200'],
            'uuid'   => ['required'],
        ]);
        if ($validator->fails()) {
            return $this->ApiResponse('fail', $validator->errors()->first());
        }
        $device = $this->deviceRepo->findWhere(['device_id' => $request['device_id'],'uuid'=>$request['uuid']])->first();
        if($device){
            $user = $device ? $device->user : null;
            if(!$user){
                return $this->ApiResponse('fail', trans('api.userUndefined'));
            }
            $this->userRepo->update([
                'online' => 0
            ],$user['id']);
            $this->deviceRepo->delete($device['id']);
        }

        return $this->successResponse();
    }
    public function ForgetPasswordCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
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
        $UnreadNotifications = $user->Notifications->where('seen', 0);
        foreach ($UnreadNotifications as $UnreadNotification){
            $this->notifyRepo->update(['seen'=>1],$UnreadNotification['id']);
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
        $this->send_notify($order['delegate_id'], ' تم تقييمك للطلب رقم ' . $order['id'] . ' من قبل العميل ', 'You have been rated from client in order num ' . $order['id'] . '', $order['id'], $order['status']);
        return $this->ApiResponse('success', app()->getLocale() == 'ar' ? 'تم تقييم هذا الطلب بنجاح' : 'this order is success rated');
    }
    /*********************** Start user wallet ***********************/
    public function Wallet(Request $request)
    {
        $user = auth()->user();
        return $this->successResponse($user['wallet']);
    }
}
