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

Route::group(['middleware' => ['auth-check', 'api-lang'], 'namespace' => 'Api\Client'], function () {
    Route::any('regions', 'SettingController@regions');
    Route::any('cities', 'SettingController@cities');
    Route::any('search', 'SettingController@search');
    Route::any('cities-search', 'SettingController@citySearch');

    Route::any('home', 'HomeController@Home');
    Route::any('slider-home', 'HomeController@sliderHome');
    Route::any('sub-categories', 'CategoryController@subCategories');
    Route::any('single-category', 'CategoryController@singleCategory');

    Route::any('questions', 'PageController@questions');
//   cart
    Route::any('add-to-cart', 'CartController@AddToCart');
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
    Route::group(['middleware' => ['jwt.verify', 'phone-activated']], function () {
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
        Route::post('delete-notification', 'AuthController@deleteNotification');
//        # wallet
        Route::any('wallet', 'AuthController@Wallet');
//        # cart
        Route::any('cart', 'CartController@Cart');
        Route::any('addNotesAndImage', 'CartController@addNotesAndImage');
        Route::any('addDateAndAddress', 'CartController@addDateAndAddress');
        Route::any('cart-details', 'CartController@cartDetails');
        Route::any('delete-cart-item', 'CartController@deleteCartItem');
        Route::any('add-coupon', 'CartController@addCoupon');
        Route::any('place-order', 'OrderController@placeOrder');


        Route::any('my-orders/{type}', 'OrderController@MyOrders');
        Route::any('order-cancel', 'OrderController@cancelOrder');
        Route::any('order-guarantee', 'OrderController@orderGuarantee');
        Route::any('order-details', 'OrderController@OrderDetails');
        Route::any('invoice', 'OrderController@invoice');
        Route::any('accept-invoice', 'OrderController@acceptInvoice');
        Route::any('refuse-invoice', 'OrderController@refuseInvoice');
        Route::any('wallet-pay', 'OrderController@walletPay');
        Route::any('wallet-bill-pay', 'OrderController@walletBillPay');
        Route::any('cash-bill-pay', 'OrderController@cashBillPay');
        Route::any('rate-order-tech', 'OrderController@rateOrderTech');
//        # chat
        Route::any('chat', 'ChatController@chat');
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

        Route::any('accept-order', 'OrderController@acceptOrder');
        Route::any('refuse-order', 'OrderController@refuseOrder');
        Route::any('arrive-to-order', 'OrderController@arriveToOrder');
        Route::any('cancel-order', 'OrderController@cancelOrder');
        Route::any('start-in-order', 'OrderController@StartInOrder');
        Route::any('finish-order', 'OrderController@FinishOrder');

        Route::any('add-bill-notes', 'BillController@addBillNotes');
        Route::any('add-service-toOrder', 'OrderController@addServiceToOrder');
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

    });
});
