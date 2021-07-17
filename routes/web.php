<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['admin-lang']], function () {
    Route::get('/', 'MainController@index');
    Route::get('change-language/{lang}', 'MainController@changeLanguage')->name('change.language');

    Route::get( 'login',[
        'uses'  => 'MainController@showLoginForm',
        'title'=>'تسجيل الدخول',
    ])->name('show.login');
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.email');
});
Route::group([ 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::group(['middleware' => ['admin', 'check-role']], function () {

        /********************************* HomeController start *********************************/
        Route::get('dashboard', [
            'uses'  => 'HomeController@dashboard',
            'as'    => 'dashboard',
            'icon'  => '<i class="nav-icon fa fa-book"></i>',
            'title' => 'الرئيسيه',
            'type'  => 'parent'
        ]);
        /********************************* HomeController end *********************************/

        /********************************* RoleController start *********************************/
        Route::get('roles', [
            'uses'      => 'RoleController@index',
            'as'        => 'roles.index',
            'title'     => 'قائمة الصلاحيات',
            'icon'      => '<i class="nav-icon fa fa-book"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.delete']
        ]);

        Route::get('roles/create',['uses'=> 'RoleController@create','as'=> 'roles.create','title'=> 'اضافة صلاحيه']);
        Route::post('roles/store',['uses'=> 'RoleController@store','as'=> 'roles.store','title'=> 'تمكين اضافة صلاحيه']);
        Route::get('roles/{id}/edit',['uses'=> 'RoleController@edit','as'=> 'roles.edit','title' => 'تعديل صلاحيه']);
        Route::put('roles/{id}',['uses'=> 'RoleController@update','as'=> 'roles.update','title' => 'تمكين تعديل صلاحيه']);
        Route::delete('roles/{id}',['uses'=> 'RoleController@destroy','as'=> 'roles.delete','title' => 'حذف صلاحيه']);
        /********************************* RoleController end *********************************/

        /********************************* SettingController , SocialController  start *********************************/
        Route::get('settings', [
            'uses'      => 'SettingController@index',
            'as'        => 'settings.index',
            'title'     => 'الاعدادات',
            'icon'      => '<i class="nav-icon fa fa-cog"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['settings.update', 'socials.store', 'socials.update']
        ]);

        Route::post('settings',['uses'=> 'SettingController@update','as'=> 'settings.update','title'=> 'تحديث الاعدادات']);
        Route::post('socials/store',['uses'=> 'SocialController@store','as'=> 'socials.store','title'=> 'اضافه وسائل التواصل']);
        Route::post('socials',['uses'=> 'SocialController@update','as'=> 'socials.update','title'=> 'تحديث وسائل التواصل']);
        /********************************* SettingController , SocialController end *********************************/

        /********************************* all users controllers start *********************************/
        Route::get('users', [
            'as'        => 'users',
            'icon'      => '<i class="fa fa-users"></i>',
            'title'     => 'المستخدمين',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'admins.index', 'admins.store', 'admins.update', 'admins.delete',
                'clients.index', 'clients.store', 'clients.update', 'clients.delete','sendnotifyuser', 'changeStatus', 'addToWallet'
            ]
        ]);

        # AdminController
        Route::get('admins',['uses'=> 'AdminController@index','as'=> 'admins.index','title'=> ' المشرفين','icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::post('admins/store',['uses'=> 'AdminController@store','as'=> 'admins.store','title'=> 'اضافة مشرف']);
        Route::post('admins/{id}',['uses'=> 'AdminController@update','as'=> 'admins.update','title'=> ' تعديل مشرف']);
        Route::delete('admins/{id}',['uses'=> 'AdminController@destroy','as'=> 'admins.delete','title'=> 'حذف مشرف']);
        # ClientController
        Route::get('clients',['uses'=> 'ClientController@index','as'=> 'clients.index','title'=> ' العملاء','icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('clients/store',['uses'=> 'ClientController@store','as'=> 'clients.store','title'=> 'اضافة عميل']);
        Route::post('clients/{id}',['uses'=> 'ClientController@update','as'=> 'clients.update','title'=> 'تعديل عميل']);
        Route::delete('clients/{id}',['uses'=> 'ClientController@destroy','as'=> 'clients.delete','title'=> 'حذف عميل']);
        Route::post('addToWallet',['uses'=> 'ClientController@addToWallet','as'=> 'addToWallet','title'=> 'اضافه الي المحفظه']);

        Route::post('send-notify-user',['uses'=> 'ClientController@sendnotifyuser','as'=> 'sendnotifyuser','title'=> 'ارسال اشعارات']);
        Route::post('change-status',['uses'=> 'ClientController@changeStatus','as'=> 'changeStatus','title'=> 'تغيير الحاله']);
        /********************************* all users controllers end *********************************/

        /*------------ start Of services Controller ----------*/
        #season page
        Route::get('services', [
            'uses'      => 'ServiceController@index',
            'as'        => 'services.index',
            'title'     => 'خدمات',
            'icon'      => '<i class="nav-icon fa fa-tags"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child' => [
                'services.store',
                'services.update',
                'services.create',
                'services.edit',
                'services.delete',
                'services.destroy',
                'services.delimage',
                'services.addFile',
                'services.changeMain',
                'services.SellerCategories',
                'services.changeStatus',
            ]
        ]);
        Route::get('services/create', [
            'uses' => 'ServiceController@create',
            'as' => 'services.create',
            'title' => 'اضافة خدمه',
        ]);
        Route::get('services/edit/{id}', [
            'uses' => 'ServiceController@edit',
            'as' => 'services.edit',
            'title' => 'تعديل خدمه',
        ]);
        Route::put('services/update/{id}', [
            'uses' => 'ServiceController@update',
            'as' => 'services.update',
            'title' => 'تحديث خدمه',
        ]);
        Route::post('services/changeStatus', [
            'uses' => 'ServiceController@changeStatus',
            'as' => 'services.changeStatus',
            'title' => 'تغيير حالة خدمه',
        ]);
        Route::post('delimage', [
            'uses' => 'ServiceController@delimage',
            'as' => 'services.delimage',
            'title' => 'حذف الصور',
        ]);
        Route::post('services/delete', [
            'uses' => 'ServiceController@delete',
            'as' => 'services.delete',
            'title' => 'حذف خدمه',
        ]);
        Route::delete('services/delete/{id}', [
            'uses' => 'ServiceController@destroy',
            'as' => 'services.destroy',
            'title' => 'حذف خدمه من الجدول',
        ]);
        Route::post('files/change', [
            'uses' => 'ServiceController@changeMain',
            'as' => 'services.changeMain',
            'title' => 'الصوره الرئيسيه',
        ]);
        Route::post('services/files', [
            'uses' => 'ServiceController@addFile',
            'as' => 'services.addFile',
            'title' => 'اضافة صور',
        ]);
        Route::post('services/store', [
            'uses' => 'ServiceController@store',
            'as' => 'services.store',
            'title' => 'حفظ خدمه',
        ]);
        Route::post('services/getSellerCategories', [
            'uses' => 'ServiceController@getSellerCategories',
            'as' => 'services.SellerCategories',
            'title' => 'أقسام المتجر',
        ]);
        /********************************* OrderController start *********************************/
        Route::get('orders', [
            'uses'      => 'OrderController@index',
            'as'        => 'orders.index',
            'title'     => ' الطلبات',
            'icon'      => '<i class="nav-icon fa fa-database"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['orders.show', 'orders.destroy']
        ]);

        Route::get('orders/{id}',['uses'=> 'OrderController@show','as'=> 'orders.show','title'=> 'مشاهدة طلب']);
        Route::delete('orders/{id}',['uses'=> 'OrderController@destroy','as'=> 'orders.destroy','title'=> 'حذف طلب']);
        /********************************* OrderController end *********************************/

        /********************************* SliderController start *********************************/
        Route::get('sliders', [
            'uses'      => 'SliderController@index',
            'as'        => 'sliders.index',
            'title'     => ' البنرات المتحركه',
            'icon'      => '<i class="nav-icon fa fa-database"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['sliders.index', 'sliders.store', 'sliders.update', 'sliders.destroy']
        ]);

        Route::post('sliders/store',['uses'=> 'SliderController@store','as'=> 'sliders.store','title'=> 'اضافة بنر']);
        Route::post('sliders/{id}',['uses'=> 'SliderController@update','as'=> 'sliders.update','title'=> 'تعديل بنر']);
        Route::delete('sliders/{id}',['uses'=> 'SliderController@destroy','as'=> 'sliders.destroy','title'=> 'حذف بنر']);
        Route::post('sliders/active/change',['uses'=> 'SliderController@changeActive','as'=> 'sliders.changeActive','title'=> 'تنشيط']);
        /********************************* SliderController end *********************************/

        /********************************* CategoryController start *********************************/
        Route::get('categories', [
            'uses'      => 'CategoryController@index',
            'as'        => 'categories.index',
            'title'     => ' الأقسام',
            'icon'      => '<i class="nav-icon fa fa-database"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => [
                'categories.index', 'categories.view', 'categories.store', 'categories.update', 'categories.destroy','categories.changeCategoryAppear','categories.changeCategoryPledge',
                'subcategories.index', 'subcategories.store', 'subcategories.update', 'subcategories.destroy','subcategories.uploadFile','subcategories.storeUploadFile',
                'banners.index','banners.store','banners.update','banners.destroy','banners.changeActive',
            ]
        ]);
        Route::post('changeCategoryAppear',['uses'=> 'CategoryController@changeCategoryAppear','as'=> 'categories.changeCategoryAppear','title'=> 'تغيير ظهور القسم']);
        Route::post('changeCategoryPladge',['uses'=> 'CategoryController@changeCategoryPladge','as'=> 'categories.changeCategoryPledge','title'=> 'تغيير ظهور التعهد']);
        Route::get('categories/view',['uses'=> 'CategoryController@view','as'=> 'categories.view','title'=> 'عرض شجري للاقسام']);
        Route::post('categories/store',['uses'=> 'CategoryController@store','as'=> 'categories.store','title'=> 'اضافة قسم']);
        Route::post('categories/{id}',['uses'=> 'CategoryController@update','as'=> 'categories.update','title'=> 'تعديل قسم']);
        Route::delete('categories/{id}',['uses'=> 'CategoryController@destroy','as'=> 'categories.destroy','title'=> 'حذف قسم']);
        /********************************* CategoryController end *********************************/
        Route::get('categories/banners/{id}',['uses'=> 'CategoryController@banners','as'=> 'banners.index','title'=> 'صفحة البانرات الثابته']);
        Route::post('categories/banners/store/{id}',['uses'=> 'CategoryController@bannerStore','as'=> 'banners.store','title'=> 'اضافة البانرات الثابته']);
        Route::post('categories/banners/{id}',['uses'=> 'CategoryController@bannerUpdate','as'=> 'banners.update','title'=> 'تعديل البانرات الثابته']);
        Route::delete('categories/banners/{id}',['uses'=> 'CategoryController@bannerDestroy','as'=> 'banners.destroy','title'=> 'حذف البانرات الثابته']);
        Route::post('banners/active/change',['uses'=> 'CategoryController@changeActive','as'=> 'banners.changeActive','title'=> 'تنشيط']);

        /********************************* SliderController start *********************************/
        Route::get('ads', [
            'uses'      => 'AdsController@index',
            'as'        => 'ads.index',
            'title'     => 'الاعلانات',
            'icon'      => '<i class="nav-icon fa fa-database"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['ads.index', 'ads.store', 'ads.update', 'ads.destroy','ads.changeActive']
        ]);

        Route::post('ads/store',['uses'=> 'AdsController@store','as'=> 'ads.store','title'=> 'اضافة اعلان']);
        Route::post('ads/{id}',['uses'=> 'AdsController@update','as'=> 'ads.update','title'=> 'تعديل اعلان']);
        Route::delete('ads/{id}',['uses'=> 'AdsController@destroy','as'=> 'ads.destroy','title'=> 'حذف اعلان']);
        Route::post('ads/active/change',['uses'=> 'AdsController@changeActive','as'=> 'ads.changeActive','title'=> 'تنشيط']);
        /********************************* SliderController end *********************************/

        /********************************* SubCategoryController start *********************************/
        Route::get('subcategories/{id}',['uses'=> 'SubCategoryController@index','as'=> 'subcategories.index','title'=> 'الأقسام الفرعيه']);
        Route::post('subcategories/store/{id}',['uses'=> 'SubCategoryController@store','as'=> 'subcategories.store','title'=> 'اضافة قسم فرعي']);
        Route::post('subcategories/{id}',['uses'=> 'SubCategoryController@update','as'=> 'subcategories.update','title'=> 'تعديل قسم فرعي']);
        Route::delete('subcategories/{id}',['uses'=> 'SubCategoryController@destroy','as'=> 'subcategories.destroy','title'=> 'حذف قسم فرعي']);
        Route::get('subcategories/uploadFile/{id}',['uses'=> 'SubCategoryController@getuploadFile','as'=> 'subcategories.uploadFile','title'=> 'العقد']);
        Route::post('subcategories/uploadFile/{id}',['uses'=> 'SubCategoryController@storeUploadFile','as'=> 'subcategories.storeUploadFile','title'=> 'حفظ العقد']);
        /********************************* SubCategoryController end *********************************/

        /********************************* CountriesController start *********************************/

//        Route::get('country', [
//            'as'        => 'country',
//            'icon'      => '<i class="nav-icon fa fa-globe"></i>',
//            'title'     => ' ادارة الدول والمدن',
//            'type'      => 'parent',
//            'sub_route' => true,
//            'child'     => ['countries.index','countries.store', 'countries.update', 'countries.destroy',
//                'cities.index', 'cities.store', 'cities.update', 'cities.destroy']
//        ]);
//
//        Route::get('countries',['uses'=> 'CountriesController@index','as'=> 'countries.index','title'=> 'الدول','icon'=> '<i class="nav-icon fa fa-flag"></i>']);
//        Route::post('countries/store',['uses'=> 'CountriesController@store','as'=> 'countries.store','title'=> 'اضافة دوله']);
//        Route::post('countries/{id}',['uses'=> 'CountriesController@update','as'=> 'countries.update','title'=> 'تعديل دوله']);
//        Route::delete('countries/{id}',['uses'=> 'CountriesController@destroy','as'=> 'countries.destroy','title'=> 'حذف دوله']);
//        /********************************* CountriesController end *********************************/
//
//        /********************************* CityController start *********************************/
//        Route::get('cities', [
//            'uses'      => 'CityController@index',
//            'as'        => 'cities.index',
//            'title'     => ' المدن',
//            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
//        ]);
//        Route::post('cities/store',['uses'=> 'CityController@store','as'=> 'cities.store','title'=> 'اضافة مدينه']);
//        Route::post('cities/{id}',['uses'=> 'CityController@update','as'=> 'cities.update','title'=> 'تعديل مدينه']);
//        Route::delete('cities/{id}',['uses'=> 'CityController@destroy','as'=> 'cities.destroy','title'=> 'حذف مدينه']);
        /********************************* CityController end *********************************/

        /********************************* PageController start *********************************/
        Route::get('pages', [
            'uses'      => 'PageController@index',
            'as'        => 'pages.index',
            'title'     => ' الصفحات الرئيسيه',
            'icon'      => '<i class="nav-icon fa fa-file-medical-alt"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['pages.index', 'pages.update']
        ]);
        Route::post('pages/{id}',['uses'=> 'PageController@update','as'=> 'pages.update','title'=> 'تعديل صفحه']);
        /********************************* PageController end *********************************/

        /********************************* ContactController start *********************************/
        Route::get('contacts', [
            'uses'      => 'ContactController@index',
            'as'        => 'contacts.index',
            'title'     => ' تواصل معنا',
            'icon'      => '<i class="nav-icon fa fa-envelope"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['contacts.index', 'contacts.update', 'contacts.destroy']
        ]);
        Route::post('contacts/{id}',['uses'=> 'ContactController@update','as'=> 'contacts.update','title'=> 'تعديل تواصل معنا']);
        Route::delete('contacts/{id}',['uses'=> 'ContactController@destroy','as'=> 'contacts.destroy','title'=> 'حذف تواصل معنا']);
        /********************************* ContactController end *********************************/
        Route::get('questions', [
            'uses'      => 'QuestionController@index',
            'as'        => 'questions.index',
            'title'     => ' الأسئله والأجوبه',
            'icon'      => '<i class="nav-icon fa fa-database"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['questions.index', 'questions.store', 'questions.update', 'questions.destroy']
        ]);

        Route::post('questions/store',['uses'=> 'QuestionController@store','as'=> 'questions.store','title'=> 'اضافة سؤال']);
        Route::post('questions/{id}',['uses'=> 'QuestionController@update','as'=> 'questions.update','title'=> 'تعديل سؤال']);
        Route::delete('questions/{id}',['uses'=> 'QuestionController@destroy','as'=> 'questions.destroy','title'=> 'حذف سؤال']);

        /********************************* ReportController start *********************************/
        Route::get('reports', [
            'uses'      => 'ReportController@index',
            'as'        => 'reports.index',
            'title'     => ' تقارير لوحة التحكم',
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['reports.index', 'reports.delete']
        ]);
        Route::delete('reports/{id}',['uses'=> 'ReportController@destroy','as'=> 'reports.delete','title'=> 'حذف تقرير']);
        /********************************* ReportController end *********************************/

        /********************************* TransController start *********************************/
        Route::get('trans', [
            'uses'      => 'TransController@index',
            'as'        => 'trans.index',
            'title'     => ' الترجمات',
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['trans.getLangDetails', 'trans.transInput']
        ]);
        Route::post('getLangDetails',['uses'=> 'TransController@getLangDetails','as'=> 'trans.getLangDetails','title'=> 'احضار ترجمه']);
        Route::post('transInput',['uses'=> 'TransController@transInput','as'=> 'trans.transInput','title'=> 'حفظ ترجمه']);
        /********************************* TransController end *********************************/

    });


});

//    ajax helper
Route::post('/admin/cities','AjaxController@getCities')->name('admin.ajax.getCities');
Route::post('/admin/getCategories','AjaxController@getCategories')->name('admin.ajax.getCategories');
Route::any('/admin/changeAccepted','AjaxController@changeAccepted')->name('ajax.changeAccepted');
Route::any('/admin/getItems','AjaxController@getItems')->name('admin.ajax.getItems');
Route::any('/admin/getAds','AjaxController@getAds')->name('admin.ajax.getAds');
Route::any('/admin/getSellers','AjaxController@getSellers')->name('admin.ajax.getSellers');

