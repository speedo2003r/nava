<?php

use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\Message;
use App\Models\Room_user;
use App\Models\Message_notification;
function Home()
{

    $colors = [ '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#7FB3D5', '#e67e22', '#229954', '#f39c12', '#F6CD61',
        '#FE8A71', '#199EC7', '#C39BD3', '#5b239c', '#73603e' ];
    $home   = [
        [
            'name'  => 'المشرفين',
            'count' => User ::where( 'role_id', '!=', 0 ) -> count(),
            'icon'  => '<i class="fa fa-users"></i>',
            'color' => $colors[ array_rand( $colors ) ]
        ]
    ];
    return $blocks[] = $home;
}
function lastWord($string){
    $pieces = explode('.', $string);
    $last_word = array_pop($pieces);

    return $last_word;
}

function distance( $lat1, $lng1, $lat2, $lng2, $unit='K' )
{
    if ( ( $lat1 == $lat2 ) && ( $lng1 == $lng2 ) ) {
        return 0;
    } else {
        $theta = $lng1 - $lng2;
        $dist  = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) + cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );
        $dist  = acos( $dist );
        $dist  = rad2deg( $dist );
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper( $unit );

        if ( $unit == "K" ) {
            return ( $miles * 1.609344 );
        } else if ( $unit == "N" ) {
            return ( $miles * 0.8684 );
        } else if ( $unit == "M" ) {
            return ( $miles * 1609.344 );
        } else {
            return $miles;
        }
    }
}
if (!function_exists('load_dep')){
    function load_dep($select = null,$dep_hide = null){
        $departments = \App\Models\Category::select('categories.title_ar as text','categories.id as id','categories.parent_id as parent','categories.parent_id as category_id')
            ->orderBy('categories.parent_id','asc')
            ->get(['text','parent','id','category_id']);
        $dep_arr = [];
        foreach($departments as $key => $department){
            $list_arr = [];
            $list_arr['icon'] = '';
            $list_arr['li_attr'] = '';
            $list_arr['a_attr'] = '';
            $list_arr['children'] = [];
            if ($select !== null and $select == $department->id){
                $list_arr['state'] = [
                    'opened'=>true,
                    'selected'=>true,
                    'disabled'=>false
                ];
            }
            if ($dep_hide !== null and $dep_hide == $department->id){
                $list_arr['state'] = [
                    'opened'=>false,
                    'selected'=>false,
                    'disabled'=>true
                ];
            }
            $code = $department->id;
            $list_arr['id'] = $department->id;
            $list_arr['parent'] = $department->parent != null ? $department->parent:'#';
            $list_arr['text'] = $department->text.($department->parent_id != null ? ' ('.$department->category['title_ar'].') ' : '');
            array_push($dep_arr,$list_arr);
        }
        return json_encode($dep_arr,JSON_UNESCAPED_UNICODE);
    }
}
function datatableTrans(){
    $langJson = [
        "sEmptyTable"=> "ليست هناك بيانات متاحة في الجدول",
        "sLoadingRecords"=> "جارٍ التحميل...",
        "sProcessing"=> "جارٍ التحميل...",
        "sLengthMenu"=> "أظهر _MENU_ مدخلات",
        "sZeroRecords"=> "لم يعثر على أية سجلات",
        "sInfo"=> "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
        "sInfoEmpty"=> "يعرض 0 إلى 0 من أصل 0 سجل",
        "sInfoFiltered"=> "(منتقاة من مجموع _MAX_ مُدخل)",
        "sInfoPostFix"=> "",
        "sSearch"=> "ابحث",
        "sUrl"=> "",
        "oPaginate"=> [
            "sFirst"=> "الأول",
            "sPrevious"=> "السابق",
            "sNext"=> "التالي",
            "sLast"=> "الأخير"
        ],
        "oAria"=> [
            "sSortAscending"=> " تفعيل لترتيب العمود تصاعدياً",
            "sSortDescending"=> ": تفعيل لترتيب العمود تنازلياً"
        ]
    ];
    return $langJson;
}
#convert arabic number to english format - user model
if (!function_exists('convert_to_english')) {
    function convert_to_english($string)
    {
        $newNumbers = range(0, 9);
        $arabic     = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        $string     = str_replace($arabic, $newNumbers, $string);
        return $string;
    }
}

if(!function_exists('generateCode')){
    function generateCode()
    {
        return '12345';
        $token = rand(11111,99999);
        return $token;
    }
}
#get value from settings DB
function settings($key)
{
    $setting = \App\Entities\Setting::firstOrCreate(['key' => $key]);
    return $setting['value'];
}
#get value from socials DB
function socials($key)
{
    $setting = \App\Entities\Social::firstOrCreate(['key' => $key]);
    return $setting['value'];
}
function updateRole( $id )
{
    //get all routes
    $routes      = Route ::getRoutes();
    $permissions = Permission ::where( 'role_id', $id ) -> pluck( 'permission' ) -> toArray();

    $m = null;
    foreach ( $routes as $value ) {
        if ( $value -> getName() !== null ) {

            //display main routes
            if ( isset( $value -> getAction()[ 'type' ] ) && $value -> getAction()[ 'type' ] == 'parent' &&
                 isset( $value -> getAction()[ 'icon' ] ) && $value -> getAction()[ 'icon' ] != null ) {

                echo '<div class = "col-xs-3">';
                echo '<div class = "per-box">';


                // main route
                echo ' <label>';
                echo '<input type = "checkbox" name = "permissions[]"';

                if ( in_array( $value -> getName(), $permissions ) )
                    echo ' checked';

                echo '  value="' . $value -> getName()
                    . '">';
                echo ' <span class = "checkmark"></span>';
                echo '<span class = "name">' . $value -> getAction()[ "title" ] . '</span>';
                echo '</label>';
                //sub routes
                if ( isset( $value -> getAction()[ "child" ] ) ) {

                    $childs = $value -> getAction()[ "child" ];
                    $r2     = Route ::getRoutes();

                    foreach ( $r2 as $r ) {
                        if ( $r -> getName() !== null && in_array( $r -> getName(), $childs ) ) {

                            echo ' <label>';
                            echo '<input type = "checkbox" name = "permissions[]"';

                            if ( in_array( $r -> getName(), $permissions ) )
                                echo ' checked ';

                            echo ' value="' . $r -> getName() . '">';
                            echo ' <span class = "checkmark"></span>';
                            echo '<span class = "name">' . $r -> getAction()[ "title" ] . '</span>';
                            echo '</label>';
                        }
                    }
                }
                echo ' </div>';
                echo '</div>';

            }
        }
    }
}

function Translate($text,$lang){
    $api  = 'trnsl.1.1.20201101T180227Z.875886c0b7db970c.7c2bd36a60d8c03bbaa408f56c5a058f73059da2';
    $url  = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$api
        .'&lang=ar' . '-' . $lang . '&text=' . urlencode($text));
    $json = json_decode($url);
    return $json->text[0];
}

function lang(){
    return App() -> getLocale();
}
if(!function_exists('creatPrivateRoom')){
    function creatPrivateRoom($user_id,$otherUser_id,$order_id = null){
        $room = Room::where(['private'=>1,'user_id'=>$user_id,'other_user_id'=>$otherUser_id,'order_id'=>$order_id])->first();
        !$room? $room = Room::where(['private'=>1,'other_user_id'=>$user_id,'user_id'=>$otherUser_id,'order_id'=>$order_id])->first():"";
        if(!$room){
            // creat new room
            $room = Room::Create([
                'type'          => 'private',
                'order_id'          => $order_id,
                'private'       => 1,
                'user_id'       => $user_id,
                'other_user_id' => $otherUser_id
            ]);

            // join user and partner to room users
            joinRoom($room->id,$user_id);
            joinRoom($room->id,$otherUser_id);
        }
        return $room;
    }
}
if(!function_exists('joinRoom')){
    function joinRoom($room_id,$user_id){
        Room_user::firstOrCreate(['room_id' => $room_id, 'user_id' => $user_id]);
    }
}
if(!function_exists('leaveRoom')){
    function leaveRoom($room_id,$user_id){
        Room_user::where(['room_id' => $room_id, 'user_id' => $user_id])->delete();
    }
}
if(!function_exists('getRoomMessages')){
    function getRoomMessages($room_id,$user_id){
        $room = Room::whereId($room_id)->first();
        if($room){
            $roomMessages = $room->Messages()->with('Message')->where('user_id',$user_id)->where('is_delete',0)->get();
            return $roomMessages;
        }
        return [];
    }
}
if(!function_exists('unreadRoomMessages')){
    function unreadRoomMessages($room_id,$user_id){
        return getRoomMessages($room_id,$user_id)->where('is_seen',0);
    }
}
if(!function_exists('readAllRoomMessages')){
    function readAllRoomMessages($room_id,$user_id){
        $messages = unreadRoomMessages($room_id,$user_id);
        if(count($messages) > 0){
            foreach($messages as $msg){
                $msg->is_seen = 1;
                $msg->save();
            }
        }
    }
}
// save message and make copy from it to every room member
// return msg with other room users socket id
if(!function_exists('saveMessage')){
    function saveMessage($room_id,$message,$sender_id,$type='text'){
        $room = Room::whereId($room_id)->first();
        $lastMessage = "";
        if($room && count($room->Users) > 0){
            // create original message
            $newMessage = new Message;
            $newMessage->body       = $message; // if message is file
            $newMessage->room_id    = $room_id;
            $newMessage->user_id    = $sender_id;
            $newMessage->type       = $type;
            $newMessage->save();

            // update for sort by last message
            $room->last_message_id = $newMessage->id;
            $room->save();

            // create message relation for every room users
            foreach($room->Users as $user){

                $newMessageNoti = new Message_notification;
                $newMessageNoti->message_id = $newMessage->id;
                $newMessageNoti->room_id    = $room_id;
                $newMessageNoti->user_id    = $user->id;

                $newMessageNoti->flagged    = 0;
                $newMessageNoti->is_delete  = 0;

                $newMessageNoti->is_seen    = $user->id == $sender_id ? 1:0;
                $newMessageNoti->is_sender  = $user->id == $sender_id? 1:0;
                //$newMessageNoti->created_at = date("Y-m-d H:i:s");

                $newMessageNoti->save();
                if($user->id == $sender_id)
                    $lastMessage = $newMessageNoti;

            }
        }
        $lastMessage = Message_notification::where('id',$lastMessage->id)->with('Message')->first();
        //$users = $room->Users->where('id','!=',$sender_id)->pluck('id');
        $users = $room->Users->where('id','!=',$sender_id)->pluck('socket_id')->filter();
        $lastMessage['other_users'] = $users;
        return $lastMessage;
    }
}
if(!function_exists('deleteMessage')){
    function deleteMessage($message_id,$user_id){
        $userMessage = Message_notification::whereId($message_id)->first();
        if($userMessage && $userMessage->user_id == $user_id){
            $userMessage->is_delete = 1;
            $userMessage->save();
        }
    }
}

if(!function_exists('dashboard_url')){
    function dashboard_url($url){
      if(env('APP_PUBLIC'))
        return url('/public/'.$url);
      return url('/'.$url);
    }
}

