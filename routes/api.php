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

Route::group(['middleware' => ['auth-check', 'api-lang','order-expire-check'], 'namespace' => 'Api\Client'], function () {
    Route::any('regions', 'SettingController@regions');
    Route::any('cities', 'SettingController@cities');
    Route::any('search', 'SettingController@search');
    Route::any('cities-search', 'SettingController@citySearch');

    Route::any('test-sent/{id}', 'SettingController@testSent');

    Route::any('home', 'HomeController@Home');
    Route::any('slider-home', 'HomeController@sliderHome');
    Route::any('sub-categories', 'CategoryController@subCategories');
    Route::any('single-category', 'CategoryController@singleCategory');

    Route::any('questions', 'PageController@questions');
//   cart
    Route::group(['namespace'=>'Cart'],function (){
        Route::any('add-to-cart', AddToCart::class);
    });
    Route::any('hours-range', 'SettingController@hoursRange');
//
//
////    pages
    Route::any('about', 'PageController@About');
    Route::any('policy', 'PageController@Policy');
//
    Route::any('site-data', 'SettingController@SiteData');
//    /***************************** SettingController End *****************************/
//    /***************************** AuthController Start *****************************/
//    client
    Route::any('sign-in', 'AuthController@Login');
    Route::any('user/sign-up', 'AuthController@UserRegister');
    Route::any('active-code', 'AuthController@Activation');
    Route::any('send-active-code', 'AuthController@sendActiveCode');
    Route::any('check-active-code', 'AuthController@checkActiveCode');
    Route::any('logout', 'AuthController@Logout');
    Route::any('forget-password', 'AuthController@ForgetPasswordCode');

//    tech
    Route::any('tech-sign-in', 'AuthController@techLogin');
//
//
//
//        # contact us
    Route::any('contact-us', 'PageController@ContactMessage');
    Route::any('pay-apple', 'PaymentController@payApple');
    Route::any('pay-visa', 'PaymentController@payVisa');
    Route::any('pay-cash', 'PaymentController@payCash');
    Route::any('pay-invoice-visa', 'PaymentController@payInvoiceVisa');
    Route::any('pay-wallet-visa', 'PaymentController@payWalletVisa');
    Route::any('pay-mada', 'PaymentController@payMada');
    Route::any('pay-invoice-mada', 'PaymentController@payInvoiceMada');
    Route::any('pay-wallet-mada', 'PaymentController@payWalletMada');
    Route::any('hyperResult', 'PaymentController@hyperResult')->name('hyperResult');
    Route::any('hyperApplePayResult', 'PaymentController@hyperApplePayResult')->name('hyperApplePayResult');
    Route::any('hyperInvoiceResult', 'PaymentController@hyperInvoiceResult')->name('hyperInvoiceResult');
    Route::any('hyperWalletResult', 'PaymentController@hyperWalletResult')->name('hyperWalletResult');
    Route::any('madaHyperResult', 'PaymentController@madaHyperResult')->name('madaHyperResult');
    Route::any('madaHyperInvoiceResult', 'PaymentController@madaHyperInvoiceResult')->name('madaHyperInvoiceResult');
    Route::any('madaHyperWalletResult', 'PaymentController@madaHyperWalletResult')->name('madaHyperWalletResult');
//
//
    Route::group(['middleware' => ['jwt.verify','check-user-active']], function () {
//        # User profile
        Route::any('profile', 'AuthController@ShowProfile');
        Route::any('profile/update', 'AuthController@UpdateProfile');
        Route::any('profile/replacePhone', 'AuthController@Activation');
        Route::any('change-password', 'AuthController@UpdatePassword');
//# Update password
        /***************************** AuthController Start *****************************/

        Route::any('fake-notifications/{id}', 'AuthController@Fakenotifications');
//        # notifications
        Route::any('notifications', 'AuthController@Notifications');
        Route::any('notification-status', 'AuthController@NotificationStatus');
        Route::any('notification-toggle', 'AuthController@NotificationToggle');
        Route::post('delete-notification', 'AuthController@deleteNotification');
//        # wallet
        Route::any('wallet', 'AuthController@Wallet');
//        # cart
        Route::any('cart', 'CartController@Cart');

        Route::group(['namespace'=>'Cart'],function (){
            Route::any('addDateAndAddress', addDateAndAddress::class);
            Route::any('addNotesAndImage', addNotesAndImage::class);
        });
        Route::any('cart-details', 'CartController@cartDetails');
        Route::any('delete-cart-item', 'CartController@deleteCartItem');


        Route::group(['namespace'=>'Coupon'],function (){
            Route::any('add-coupon', addCoupon::class);
        });

        Route::any('my-orders/{type}', 'OrderController@MyOrders');
        Route::group(['namespace'=>'Order'],function (){
            Route::any('order-cancel', CancelOrder::class);
            Route::any('order-guarantee', OrderGuarantee::class);
            Route::any('rate-order-tech', RateOrderTech::class);
            Route::any('place-order', PlaceOrder::class);
        });
        Route::group(['namespace'=>'Invoice'],function (){
            Route::any('invoice', Invoice::class);
            Route::any('accept-invoice', AcceptInvoice::class);
            Route::any('refuse-invoice', RefuseInvoice::class);
        });
        Route::any('order-details', 'OrderController@OrderDetails');



        Route::any('wallet-pay', 'PaymentController@walletPay');
//        # chat
        Route::any('chat', 'ChatController@chat');
        Route::any('contact-chat', 'ChatController@ContactChat');
        Route::any('sendMessage', 'ChatController@sendMessage');
    });
});
Route::group(['middleware' => ['auth-check', 'api-lang'], 'namespace' => 'Api\Tech'], function () {

    Route::group(['middleware' => ['jwt.verify', 'phone-activated']], function () {

//          technical
        Route::any('new-orders', 'OrderController@NewOrders');
        Route::any('current-orders', 'OrderController@CurrentOrders');
        Route::any('finished-orders', 'OrderController@FinishedOrders');
        Route::any('guarantee-orders', 'OrderController@GuaranteeOrders');

        Route::group(['namespace'=>'Order'],function (){
            Route::any('accept-order', AcceptOrder::class);
            Route::any('arrive-to-order', ArriveToOrder::class);
            Route::any('start-in-order', StartInOrder::class);
            Route::any('refuse-order', RefuseOrder::class);
            Route::any('cancel-order', CancelOrder::class);
            Route::any('finish-order', FinishOrder::class);
        });

        Route::any('add-bill-notes', 'BillController@addBillNotes');

        Route::any('add-service-toOrder', 'OrderController@addServiceToOrder');
        Route::any('add-service-notify', 'OrderController@addServiceNotify');
        Route::any('services-order', 'OrderController@servicesOrder');
        Route::any('del-service-order', 'OrderController@delServiceOrder');

        Route::any('tech-order-details', 'OrderController@orderDetails');

        Route::any('tech-order-categories', 'CategoryController@techOrderCategories');
        Route::any('tech-order-services', 'CategoryController@techOrderServices');

        Route::any('statistics', 'StatisticController@statistics');
        Route::any('tech-wallet', 'StatisticController@techWallet');
        Route::any('download-pdf', 'StatisticController@downloadPdf');

//        companies
        Route::any('technicals', 'CompanyController@technicals');
        Route::any('order-transfer', 'CompanyController@orderTransfer');
//        # chat
        Route::any('tech-chat', 'ChatController@chat');
        Route::any('techSendMessage', 'ChatController@sendMessage');

    });
});
