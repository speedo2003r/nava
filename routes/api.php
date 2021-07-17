<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth-check', 'api-lang'], 'namespace' => 'Api'], function () {
    Route::any('questions', 'SettingController@questions');
    Route::any('intros', 'SettingController@intros');
    Route::any('home', 'SettingController@Home');
    Route::any('select-home-category', 'SettingController@selectHomeCategory');
    Route::any('single-sub-category', 'CategoryController@singleCategory');

    Route::any('single-ad', 'AdController@singleAd');

    Route::any('single-provider', 'ProviderController@singleProvider');


//    pages
    Route::any('about', 'SettingController@About');
    Route::any('policy', 'SettingController@Policy');

    Route::any('site-data', 'SettingController@SiteData');
//    /***************************** SettingController End *****************************/
//    /***************************** CartController start *****************************/
//    Route::any('write-note', 'CartController@writeNote');
//
//    /***************************** AuthController Start *****************************/
    Route::any('user/sign-up', 'AuthController@UserRegister');
//
//    # Code For Active User
//    Route::any('reset-password', 'AuthController@resetPassword');
    Route::any('send-active-code', 'AuthController@sendActiveCode');
    Route::any('active-code', 'AuthController@Activation');
    Route::any('resend-code', 'AuthController@ResendActiveCode');
//    search
    Route::any('search-provider', 'SearchController@searchProvider');
    Route::any('search-single-provider', 'SearchController@searchSingleProvider');
    Route::any('search-service', 'SearchController@searchService');

    Route::any('sign-in', 'AuthController@Login');

    Route::any('logout', 'AuthController@Logout');

//        # contact us
    Route::any('contact-us', 'SettingController@ContactMessage');
//        # complaints
    Route::any('complaints', 'SettingController@complaints');

    # Forany Password
    Route::any('forget-password', 'AuthController@ForgetPasswordCode');

//        delegates Controllers
    Route::any('validateRegister', 'AuthController@validateRegister');
    Route::group(['middleware' => ['cors', 'jwt.verify', 'phone-activated']], function () {
# Update password
//
        Route::any('change-password', 'AuthController@UpdatePassword');
//
        Route::any('edit-lang', 'AuthController@EditLang');
//
//        # switch notification status for receive fcm or not
        Route::any('edit-notification-status', 'AuthController@NotificationStatus');
//
//        # User profile
        Route::any('profile', 'AuthController@ShowProfile');
        Route::any('profile/update', 'AuthController@UpdateProfile');
//
//        // user fake data
        Route::any('fake-notifications/{id}', 'AuthController@Fakenotifications');
//        # notifications
        Route::any('notifications', 'AuthController@Notifications');
        Route::any('unread-notifications', 'AuthController@UnreadNotifications');
        Route::delete('delete-notification', 'AuthController@deleteNotification');
//
//
//        # wallet
        Route::any('wallet', 'AuthController@Wallet');
        Route::any('wallet-pay', 'AuthController@walletPay');
//        # cart
        Route::any('add-to-cart', 'CartController@AddToCart');
        Route::any('cart', 'CartController@Cart');
        Route::any('delete-cart-order', 'CartController@deleteCartOrder');
        Route::any('single-cart', 'CartController@singleCart');
//        # order
        Route::any('cancel-order', 'OrderController@cancelOrder');
        Route::any('place-order', 'OrderController@placeOrder');
        Route::any('my-orders/{type}', 'OrderController@MyOrders');
        Route::any('order-details', 'OrderController@OrderDetails');
        Route::any('order-pay', 'OrderController@OrderPay');
        Route::any('finish-order', 'OrderController@finishOrder');
        Route::any('finish-order-pay', 'OrderController@finishOrderPay');


        Route::any('view-contract', 'OrderController@viewContract');
        Route::any('download-pdf', 'OrderController@downloadPdf');
        Route::any('accept-contract', 'OrderController@acceptContract');
        Route::any('refuse-contract', 'OrderController@refuseContract');

//
//        # rating
        Route::any('review', 'AuthController@review');
//        # chat
        Route::any('rooms', 'ChatController@rooms');
        Route::any('chat', 'ChatController@chat');
        Route::any('sendMessage', 'ChatController@sendMessage');
//
//


    });
});
