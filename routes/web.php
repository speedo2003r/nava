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

    Route::get( '/login',[
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
Route::group([ 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::post('login', 'AuthController@login')->name('login');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::group(['middleware' => ['admin', 'check-role']], function () {

        /********************************* HomeController start *********************************/
        Route::get('dashboard', [
            'uses'  => 'HomeController@dashboard',
            'as'    => 'dashboard',
            'title' => awtTrans('الرئيسيه'),
            'icon'  => asset('assets/media/menuicon/home.svg'),
            'type'  => 'parent',
            'sub_route' => false,
            'child'     => ['financial','notifications']
        ]);
        Route::post('financial',['uses'=>'HomeController@financialReport','as'=>'financial','title'=>awtTrans('التقرير المالي')]);
        Route::get('notifications',['uses'=>'HomeController@notifications','as'=>'notifications','title'=>awtTrans('الاشعارات')]);
        /********************************* HomeController end *********************************/

        /********************************* RoleController start *********************************/
        Route::get('roles', [
            'uses'      => 'RoleController@index',
            'as'        => 'roles.index',
            'title'     => awtTrans('قائمة الصلاحيات'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.delete']
        ]);

        Route::get('roles/create',['uses'=> 'RoleController@create','as'=> 'roles.create','title'=> awtTrans('اضافة صلاحيه')]);
        Route::post('roles/store',['uses'=> 'RoleController@store','as'=> 'roles.store','title'=> awtTrans('تمكين اضافة صلاحيه')]);
        Route::get('roles/{id}/edit',['uses'=> 'RoleController@edit','as'=> 'roles.edit','title' => awtTrans('تعديل صلاحيه')]);
        Route::put('roles/{id}',['uses'=> 'RoleController@update','as'=> 'roles.update','title' => awtTrans('تمكين تعديل صلاحيه')]);
        Route::delete('roles/{id}',['uses'=> 'RoleController@destroy','as'=> 'roles.delete','title' => awtTrans('حذف صلاحيه')]);
        /********************************* RoleController end *********************************/

        /********************************* SettingController , SocialController  start *********************************/
        Route::get('settings', [
            'uses'      => 'SettingController@index',
            'as'        => 'settings.index',
            'title'     => awtTrans('الاعدادات'),
            'icon'      => asset('assets/media/menuicon/gear.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['settings.update', 'socials.store', 'socials.update']
        ]);

        Route::post('settings',['uses'=> 'SettingController@update','as'=> 'settings.update','title'=> awtTrans('تحديث الاعدادات')]);
        Route::post('socials/store',['uses'=> 'SocialController@store','as'=> 'socials.store','title'=> awtTrans('اضافه وسائل التواصل')]);
        Route::post('socials',['uses'=> 'SocialController@update','as'=> 'socials.update','title'=> awtTrans('تحديث وسائل التواصل')]);
        /********************************* SettingController , SocialController end *********************************/

        /********************************* all users controllers start *********************************/
        Route::get('users', [
            'as'        => 'users',
            'icon'      => asset('assets/media/menuicon/shield.svg'),
            'title'     => awtTrans('المستخدمين'),
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'admins.index', 'admins.store', 'admins.update', 'admins.delete','admins.chatStatus',
                'clients.index', 'clients.store', 'clients.update', 'clients.delete',
                'technicians.index', 'technicians.store', 'technicians.update', 'technicians.delete','technicians.orders', 'technicians.decreaseVal', 'technicians.selectCategories','technicians.accounts','technicians.accountsDelete','technicians.settlement',
                'companies.index', 'companies.store', 'companies.update', 'companies.delete','companies.accounts', 'companies.images','companies.storeImages',
                'companies.technicians','companies.storeTechnicians','companies.updateTechnicians','companies.deleteTechnicians',
                'otp',
//                'accountants.index', 'accountants.store', 'accountants.update', 'accountants.delete',
                'sendnotifyuser', 'changeStatus','changeNotify', 'addToWallet'
            ]
        ]);

        # AdminController
        Route::get('admins',['uses'=> 'AdminController@index','as'=> 'admins.index','title'=> awtTrans('المشرفين'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::post('admins/change/chatStatus',['uses'=> 'AdminController@chatStatus','as'=> 'admins.chatStatus','title'=> awtTrans('استقبال المحادثه')]);
        Route::post('admins/store',['uses'=> 'AdminController@store','as'=> 'admins.store','title'=> awtTrans('اضافة مشرف')]);
        Route::post('admins/{id}',['uses'=> 'AdminController@update','as'=> 'admins.update','title'=> awtTrans('تعديل مشرف')]);
        Route::delete('admins/{id}',['uses'=> 'AdminController@destroy','as'=> 'admins.delete','title'=> awtTrans('حذف مشرف')]);
        # ClientController
        Route::get('clients',['uses'=> 'ClientController@index','as'=> 'clients.index','title'=> awtTrans('العملاء'),'icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('clients/store',['uses'=> 'ClientController@store','as'=> 'clients.store','title'=> awtTrans('اضافة عميل')]);
        Route::post('clients/{id}',['uses'=> 'ClientController@update','as'=> 'clients.update','title'=> awtTrans('تعديل عميل')]);
        Route::delete('clients/{id}',['uses'=> 'ClientController@destroy','as'=> 'clients.delete','title'=> awtTrans('حذف عميل')]);
        Route::post('addToWallet',['uses'=> 'ClientController@addToWallet','as'=> 'addToWallet','title'=> awtTrans('اضافه الي المحفظه')]);
        # TechnicianController
        Route::get('technicians',['uses'=> 'TechnicianController@index','as'=> 'technicians.index','title'=> awtTrans('التقني'),'icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('technicians/store',['uses'=> 'TechnicianController@store','as'=> 'technicians.store','title'=> awtTrans('اضافة تقني')]);
        Route::post('technicians/{id}',['uses'=> 'TechnicianController@update','as'=> 'technicians.update','title'=> awtTrans('تعديل تقني')]);
        Route::delete('technicians/{id}',['uses'=> 'TechnicianController@destroy','as'=> 'technicians.delete','title'=> awtTrans('حذف تقني')]);
        Route::get('technicians/accounts/{id}',['uses'=> 'TechnicianController@accounts','as'=> 'technicians.accounts','title'=> awtTrans('كشف حساب تقني')]);
        Route::get('technicians/orders/{id}',['uses'=> 'TechnicianController@orders','as'=> 'technicians.orders','title'=> awtTrans('الطلبات')]);
        Route::post('technicians/accounts/settlement',['uses'=> 'TechnicianController@settlement','as'=> 'technicians.settlement','title'=> awtTrans('تسوية حساب تقني')]);
        Route::delete('technicians/accounts/delete',['uses'=> 'TechnicianController@accountsDelete','as'=> 'technicians.accountsDelete','title'=> awtTrans('حذف كشف حساب تقني')]);
        Route::post('decreaseVal',['uses'=> 'TechnicianController@decreaseVal','as'=> 'technicians.decreaseVal','title'=> awtTrans('خصم')]);
        Route::post('technicians/select/categories',['uses'=> 'TechnicianController@selectCategories','as'=> 'technicians.selectCategories','title'=> awtTrans('اختيار التخصصات')]);
        # CompanyController
        Route::get('companies',['uses'=> 'CompanyController@index','as'=> 'companies.index','title'=> awtTrans('الشركات'),'icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('companies/store',['uses'=> 'CompanyController@store','as'=> 'companies.store','title'=> awtTrans('اضافة شركه')]);
        Route::post('companies/{id}',['uses'=> 'CompanyController@update','as'=> 'companies.update','title'=> awtTrans('تعديل شركه')]);
        Route::delete('companies/{id}',['uses'=> 'CompanyController@destroy','as'=> 'companies.delete','title'=> awtTrans('حذف شركه')]);
        Route::get('companies/accounts/{id}',['uses'=> 'CompanyController@accounts','as'=> 'companies.accounts','title'=> awtTrans('كشف حساب الشركه')]);

        Route::get('companies/images/{id}', ['uses' => 'CompanyController@images','as' => 'companies.images','title' => awtTrans('معرض الصور للشركه')]);
        Route::post('companies/images/{id}', ['uses' => 'CompanyController@storeImages','as' => 'companies.storeImages','title' => awtTrans('حفظ معرض الصور للشركه')]);

        Route::get('companies/technicians/{id}', ['uses' => 'TechnicianCompanyController@index','as' => 'companies.technicians','title' => awtTrans('التقنيين التابعين للشركه')]);
        Route::post('companies/storeTechnicians/{id}', ['uses' => 'TechnicianCompanyController@store','as' => 'companies.storeTechnicians','title' => awtTrans('حفظ التقنيين التابعين للشركه')]);
        Route::post('companies/updateTechnicians/{id}', ['uses' => 'TechnicianCompanyController@update','as' => 'companies.updateTechnicians','title' => awtTrans('تعديل التقنيين التابعين للشركه')]);
        Route::delete('companies/deleteTechnicians', ['uses' => 'TechnicianCompanyController@delete','as' => 'companies.deleteTechnicians','title' => awtTrans('حذف التقنيين التابعين للشركه')]);

        Route::get('otp', ['uses' => 'OtpController@index','as' => 'otp','title' => awtTrans('OTP'),'icon'=> '<i class="nav-icon fa fa-users"></i>']);
        # AccountController
        Route::get('accountants',['uses'=> 'AccountantController@index','as'=> 'accountants.index','title'=> ' المحاسبين','icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('accountants/store',['uses'=> 'AccountantController@store','as'=> 'accountants.store','title'=> 'اضافة محاسب']);
        Route::post('accountants/{id}',['uses'=> 'AccountantController@update','as'=> 'accountants.update','title'=> 'تعديل محاسب']);
        Route::delete('accountants/{id}',['uses'=> 'AccountantController@destroy','as'=> 'accountants.delete','title'=> 'حذف محاسب']);

        Route::post('send-notify-user',['uses'=> 'ClientController@sendnotifyuser','as'=> 'sendnotifyuser','title'=> awtTrans('ارسال اشعارات')]);
        Route::post('change-status',['uses'=> 'ClientController@changeStatus','as'=> 'changeStatus','title'=> awtTrans('تغيير الحاله')]);
        Route::post('change-notify',['uses'=> 'ClientController@changeNotify','as'=> 'changeNotify','title'=> awtTrans('تغيير حالة استقبال الطلبات')]);
        /********************************* all users controllers end *********************************/

        #statistics routes
        Route::get('/statistics',[
            'uses'=>'StatisticsController@statistics',
            'as'=>'admin.statistics',
            'title'=>awtTrans('ادارة الاحصائيات'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => true,
            'child' => [
//                'statistics.clients',
                'statistics.visits',
                'statistics.almostOrder',
//                'statistics.search',
                'statistics.getdata',
            ]
        ]);

        Route::get('/statistics/clients',['uses'=>'StatisticsController@clients','as'=>'statistics.clients','title'=>awtTrans('العملاء'),'icon' => '<i class="nav-icon fa fa-list"></i>']);
        Route::get('/statistics/visits',['uses'=>'StatisticsController@visits','as'=>'statistics.visits','title'=>awtTrans('الزيارات'),'icon' => '<i class="nav-icon fa fa-list"></i>']);
        Route::get('/statistics/almostorder',['uses'=>'StatisticsController@almostOrder','as'=>'statistics.almostOrder','title'=>awtTrans('الأكثر طلبا'),'icon' => '<i class="nav-icon fa fa-list"></i>']);
//        Route::get('/statistics/search',['uses'=>'StatisticsController@search','as'=>'statistics.search','title'=>'الأكثر بحثا','icon' => '<i class="nav-icon fa fa-list"></i>']);
        Route::post('/statistics/getdata',['uses'=>'StatisticsController@getdata','as'=>'statistics.getdata','title'=>awtTrans('جلب البيانات')]);

        /********************************* CountriesController start *********************************/

        Route::get('country', [
            'as'        => 'country',
            'icon'      => asset('assets/media/menuicon/earth.svg'),
            'title'     => awtTrans('الاداره الجيوجرافيه'),
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'countries.index','countries.store', 'countries.update', 'countries.destroy',
                'cities.index', 'cities.store', 'cities.update', 'cities.destroy',
                'regions.index', 'regions.store', 'regions.update', 'regions.destroy',
                'branches.index','branches.create', 'branches.store','branches.edit', 'branches.update', 'branches.destroy',
            ]
        ]);

        Route::get('countries',['uses'=> 'CountriesController@index','as'=> 'countries.index','title'=> awtTrans('الدول'),'icon'=> '<i class="nav-icon fa fa-flag"></i>']);
        Route::post('countries/store',['uses'=> 'CountriesController@store','as'=> 'countries.store','title'=> awtTrans('اضافة دوله')]);
        Route::post('countries/{id}',['uses'=> 'CountriesController@update','as'=> 'countries.update','title'=> awtTrans('تعديل دوله')]);
        Route::delete('countries/{id}',['uses'=> 'CountriesController@destroy','as'=> 'countries.destroy','title'=> awtTrans('حذف دوله')]);
        /********************************* CountriesController end *********************************/

        /********************************* CityController start *********************************/
        Route::get('cities', [
            'uses'      => 'CityController@index',
            'as'        => 'cities.index',
            'title'     => awtTrans('المدن'),
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::post('cities/store',['uses'=> 'CityController@store','as'=> 'cities.store','title'=> awtTrans('اضافة مدينه')]);
        Route::post('cities/{id}',['uses'=> 'CityController@update','as'=> 'cities.update','title'=> awtTrans('تعديل مدينه')]);
        Route::delete('cities/{id}',['uses'=> 'CityController@destroy','as'=> 'cities.destroy','title'=> awtTrans('حذف مدينه')]);
        /********************************* CityController end *********************************/

        /********************************* RegionController start *********************************/
        Route::get('regions', [
            'uses'      => 'RegionController@index',
            'as'        => 'regions.index',
            'title'     => awtTrans('المناطق'),
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::post('regions/store',['uses'=> 'RegionController@store','as'=> 'regions.store','title'=> awtTrans('اضافة منطقه')]);
        Route::post('regions/{id}',['uses'=> 'RegionController@update','as'=> 'regions.update','title'=> awtTrans('تعديل منطقه')]);
        Route::delete('regions/{id}',['uses'=> 'RegionController@destroy','as'=> 'regions.destroy','title'=> awtTrans('حذف منطقه')]);
        /********************************* RegionController end *********************************/

        /********************************* RegionController start *********************************/
        Route::get('branches', [
            'uses'      => 'BranchController@index',
            'as'        => 'branches.index',
            'title'     => awtTrans('المواقع'),
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::get('branches/create',['uses'=> 'BranchController@create','as'=> 'branches.create','title'=> awtTrans('صفحة اضافة موقع')]);
        Route::post('branches/store',['uses'=> 'BranchController@store','as'=> 'branches.store','title'=> awtTrans('اضافة موقع')]);
        Route::get('branches/{id}',['uses'=> 'BranchController@edit','as'=> 'branches.edit','title'=> awtTrans('صفحة تعديل موقع')]);
        Route::post('branches/{id}',['uses'=> 'BranchController@update','as'=> 'branches.update','title'=> awtTrans('تعديل موقع')]);
        Route::delete('branches/{id}',['uses'=> 'BranchController@destroy','as'=> 'branches.destroy','title'=> awtTrans('حذف موقع')]);
        /********************************* RegionController end *********************************/

        /********************************* CategoryController start *********************************/
        Route::get('categories', [
            'uses'      => 'CategoryController@index',
            'as'        => 'categories.index',
            'title'     => awtTrans('الأقسام'),
            'icon'      => asset('assets/media/menuicon/services.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => [
                'categories.index', 'categories.view', 'categories.store', 'categories.update', 'categories.destroy',
                'subcategories.index', 'subcategories.store', 'subcategories.update', 'subcategories.destroy','categories.changeCategoryAppear'
            ]
        ]);
        Route::get('categories/view',['uses'=> 'CategoryController@view','as'=> 'categories.view','title'=> awtTrans('عرض شجري للاقسام')]);
        Route::post('categories/store',['uses'=> 'CategoryController@store','as'=> 'categories.store','title'=> awtTrans('اضافة قسم')]);
        Route::post('categories/{id}',['uses'=> 'CategoryController@update','as'=> 'categories.update','title'=> awtTrans('تعديل قسم')]);
        Route::delete('categories/{id}',['uses'=> 'CategoryController@destroy','as'=> 'categories.destroy','title'=> awtTrans('حذف قسم')]);
        Route::post('categories/changeCategory/Appear',['uses'=> 'CategoryController@changeCategoryAppear','as'=> 'categories.changeCategoryAppear','title'=> awtTrans('تنشيط القسم')]);

        /********************************* SubCategoryController start *********************************/
        Route::get('subcategories/{id}',['uses'=> 'SubCategoryController@index','as'=> 'subcategories.index','title'=> awtTrans('الأقسام الفرعيه')]);
        Route::post('subcategories/store/{id}',['uses'=> 'SubCategoryController@store','as'=> 'subcategories.store','title'=> awtTrans('اضافة قسم فرعي')]);
        Route::post('subcategories/{id}',['uses'=> 'SubCategoryController@update','as'=> 'subcategories.update','title'=> awtTrans('تعديل قسم فرعي')]);
        Route::delete('subcategories/{id}',['uses'=> 'SubCategoryController@destroy','as'=> 'subcategories.destroy','title'=> awtTrans('حذف قسم فرعي')]);
        /********************************* SubCategoryController end *********************************/

        /*------------ start Of services Controller ----------*/
        #season page
        Route::get('services', [
            'uses'      => 'ServiceController@index',
            'as'        => 'services.index',
            'title'     => awtTrans('خدمات'),
            'icon'      => asset('assets/media/menuicon/customer-support.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child' => [
                'services.getFilterData',
                'services.store',
                'services.update',
                'services.destroy',
                'services.changeStatus',
//                'parts.index',
//                'parts.store',
//                'parts.update',
//                'parts.destroy',
            ]
        ]);
        Route::get('services/getFilterData', [
            'uses' => 'ServiceController@getFilterData',
            'as' => 'services.getFilterData',
            'title' => awtTrans('جلب بيانات الخدمات'),
        ]);
        Route::post('services/store', [
            'uses' => 'ServiceController@store',
            'as' => 'services.store',
            'title' => awtTrans('اضافة خدمه'),
        ]);
        Route::post('services/update/{id}', [
            'uses' => 'ServiceController@update',
            'as' => 'services.update',
            'title' => awtTrans('تحديث خدمه'),
        ]);
        Route::post('services/changeStatus', [
            'uses' => 'ServiceController@changeStatus',
            'as' => 'services.changeStatus',
            'title' => awtTrans('تغيير حالة خدمه'),
        ]);
        Route::delete('services/delete/{id}', [
            'uses' => 'ServiceController@destroy',
            'as' => 'services.destroy',
            'title' => awtTrans('حذف خدمه من الجدول'),
        ]);
//        Route::get('parts/{id}', [
//            'uses' => 'PartsController@index',
//            'as' => 'parts.index',
//            'title' => 'قطع الغيار',
//        ]);
//        Route::post('parts/store', [
//            'uses' => 'PartsController@store',
//            'as' => 'parts.store',
//            'title' => 'اضافة قطعة الغيار',
//        ]);
//        Route::post('parts/update/{id}', [
//            'uses' => 'PartsController@update',
//            'as' => 'parts.update',
//            'title' => 'تحديث قطعة الغيار',
//        ]);
//        Route::delete('parts/delete/{id}', [
//            'uses' => 'PartsController@destroy',
//            'as' => 'parts.destroy',
//            'title' => 'حذف قطعة الغيار',
//        ]);

        /********************************* OrderController start *********************************/
        Route::get('allorders', [
            'as'        => 'orders',
            'title'     => awtTrans('الطلبات'),
            'icon'      => asset('assets/media/menuicon/gear.svg'),
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => ['orders.index','orders.onWayOrders','orders.finishedOrders','orders.canceledOrders','orders.guaranteeOrders','orders.delayedOrders','orders.timeOutOrders','orders.guaranteeShow','orders.guaranteeDestroy','orders.show','orders.operationNotes','orders.billCreate','orders.billUpdate', 'orders.changeStatus', 'orders.changeAddress', 'orders.changePayType', 'orders.changeAllAddress','orders.changeTime','orders.changeDate','orders.assignTech', 'orders.servicesUpdate','orders.acceptBill','orders.rejectBill','orders.servicesDelete','orders.partsDestroy', 'orders.rejectOrder', 'orders.destroy']
        ]);

        Route::get('orders',['uses'=> 'OrderController@index','as'=> 'orders.index','title'=> awtTrans('الطلبات الجديده'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('onWayOrders',['uses'=> 'OrderController@index','as'=> 'orders.onWayOrders','title'=> awtTrans('الطلبات قيد التنفيذ'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('finishedOrders',['uses'=> 'OrderController@index','as'=> 'orders.finishedOrders','title'=> awtTrans('الطلبات المنتهيه'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('canceledOrders',['uses'=> 'OrderController@index','as'=> 'orders.canceledOrders','title'=> awtTrans('الطلبات الملغيه'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('guaranteeOrders',['uses'=> 'OrderController@guarantees','as'=> 'orders.guaranteeOrders','title'=> awtTrans('طلبات الضمان'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('delayedOrders',['uses'=> 'OrderController@index','as'=> 'orders.delayedOrders','title'=> awtTrans('طلبات المتأخره'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('timeOutOrders',['uses'=> 'OrderController@index','as'=> 'orders.timeOutOrders','title'=> awtTrans('طلبات نفذ وقتها'),'icon'=> '<i class="nav-icon fa fa-user-tie"></i>']);
        Route::get('guaranteeOrders/show/{id}',['uses'=> 'OrderController@guaranteeShow','as'=> 'orders.guaranteeShow','title'=> awtTrans('مشاهدة طلب الضمان')]);
        Route::delete('guaranteeOrders/destroy/{id}',['uses'=> 'OrderController@guaranteeDestroy','as'=> 'orders.guaranteeDestroy','title'=> awtTrans('حذف طلب الضمان')]);
        Route::get('orders/{id}',['uses'=> 'OrderController@show','as'=> 'orders.show','title'=> awtTrans('مشاهدة طلب')]);
        Route::post('orders/rejectOrder',['uses'=> 'OrderController@rejectOrder','as'=> 'orders.rejectOrder','title'=> awtTrans('رفض الطلب')]);
        Route::post('orders/change/address',['uses'=> 'OrderController@changeAddress','as'=> 'orders.changeAddress','title'=> awtTrans('تغيير عنوان الطلب')]);
        Route::post('orders/change/allAddress',['uses'=> 'OrderController@changeAllAddress','as'=> 'orders.changeAllAddress','title'=> awtTrans('تغيير عنوان الطلب بالكامل')]);
        Route::post('orders/change/payType',['uses'=> 'OrderController@changePayType','as'=> 'orders.changePayType','title'=> awtTrans('تغيير طريقة الدفع')]);
        Route::post('orders/change/operationNotes',['uses'=> 'OrderController@operationNotes','as'=> 'orders.operationNotes','title'=> awtTrans('ملاحظات الأبوريشن')]);
        Route::post('orders/bill/create',['uses'=> 'OrderController@billCreate','as'=> 'orders.billCreate','title'=> awtTrans('اضافة فاتوره')]);
        Route::post('orders/bill/update/{id}',['uses'=> 'OrderController@billUpdate','as'=> 'orders.billUpdate','title'=> awtTrans('تعديل فاتوره')]);
        Route::post('orders/bill/accept',['uses'=> 'OrderController@billAccept','as'=> 'orders.acceptBill','title'=> awtTrans('الموافقه علي الفاتوره')]);
        Route::post('orders/bill/reject',['uses'=> 'OrderController@billReject','as'=> 'orders.rejectBill','title'=> awtTrans('رفض الفاتوره')]);
        Route::post('orders/services/update',['uses'=> 'OrderController@servicesUpdate','as'=> 'orders.servicesUpdate','title'=> awtTrans('تعديل خدمه بالطلب')]);
        Route::post('orders/services/delete',['uses'=> 'OrderController@servicesDelete','as'=> 'orders.servicesDelete','title'=> awtTrans('حذف خدمه بالطلب')]);
        Route::post('orders/assignTech',['uses'=> 'OrderController@assignTech','as'=> 'orders.assignTech','title'=> awtTrans('اختيار تقني')]);
        Route::post('orders/changeStatus',['uses'=> 'OrderController@changeStatus','as'=> 'orders.changeStatus','title'=> awtTrans('تغيير الحاله')]);
        Route::post('orders/changeDate',['uses'=> 'OrderController@changeDate','as'=> 'orders.changeDate','title'=> awtTrans('تغيير تاريخ الطلب')]);
        Route::post('orders/changeTime',['uses'=> 'OrderController@changeTime','as'=> 'orders.changeTime','title'=> awtTrans('تغيير وقت الطلب')]);
        Route::delete('orders/{id}',['uses'=> 'OrderController@destroy','as'=> 'orders.destroy','title'=> awtTrans('حذف طلب')]);
        Route::delete('orders/parts/{id}',['uses'=> 'OrderController@partsDestroy','as'=> 'orders.partsDestroy','title'=> awtTrans('حذف قطعة الغيار')]);
        /********************************* OrderController end *********************************/

        /*------------ start Of chat----------*/
        Route::get('chats', [
            'uses'      => 'ChatController@index',
            'as'        => 'chats.index',
            'title'     => awtTrans('سجل المحادثات'),
            'icon'      => asset('assets/media/menuicon/chat.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['chats.index','chats.store','chats.users','chats.room','chats.destroy','chats.privateRoom']
        ]);


        #store chats
        Route::post('chats/store', [
            'uses'      => 'ChatController@SaveMessage',
            'as'        => 'chats.store',
            'title'     => awtTrans('حفظ المحادثه')
        ]);

        #store chats
        Route::delete('chats/{id}', [
            'uses'      => 'ChatController@destroy',
            'as'        => 'chats.destroy',
            'title'     => awtTrans('حذف المحادثه')
        ]);

        #store chats
        Route::get('chats/room/{id}', [
            'uses'      => 'ChatController@ViewMessages',
            'as'        => 'chats.room',
            'title'     => awtTrans('مشاهدة المحادثه')
        ]);

        #store chats
        Route::get('chats/users', [
            'uses'      => 'ChatController@OtherUsers',
            'as'        => 'chats.users',
            'title'     => awtTrans('المستخدمين')
        ]);
        #store private chat
        Route::get('create-private-room/{id}', [
            'uses'      => 'ChatController@NewPrivateRoom',
            'as'        => 'chats.privateRoom',
            'title'     => awtTrans('اضافة غرفة دردشه')
        ]);
        Route::get('financial-management',[
            'as'        => 'financial',
            'title'     => awtTrans('الادراه الماليه'),
            'icon'      => asset('assets/media/menuicon/surface1.svg'),
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => ['financial.statistics','financial.orders','financial.dailyOrders','financial.orderShow','financial.catServ']
        ]);
        Route::get('financial',['uses'=> 'FinancialController@statistics','as'=> 'financial.statistics','title'=> awtTrans('احصائيات الطلبات'),'icon' => asset('assets/media/menuicon/surface1.svg')]);
        Route::get('financial/orders',['uses'=> 'FinancialController@orders','as'=> 'financial.orders','title'=> awtTrans('تقارير الطلبات'),'icon' => asset('assets/media/menuicon/surface1.svg')]);
        Route::get('financial/orders/show/{id}',['uses'=> 'FinancialController@orderShow','as'=> 'financial.orderShow','title'=> awtTrans('مشاهدة الطلب')]);
        Route::get('financial/dailyOrders',['uses'=> 'FinancialController@dailyOrders','as'=> 'financial.dailyOrders','title'=> awtTrans('الايرادات اليوميه'),'icon' => asset('assets/media/menuicon/surface1.svg')]);
        Route::get('financial/catServ',['uses'=> 'FinancialController@catServ','as'=> 'financial.catServ','title'=> awtTrans('ايرادات الأقسام والخدمات'),'icon' => asset('assets/media/menuicon/surface1.svg')]);

        Route::get('reviews',[
            'as'        => 'reviews.index',
            'uses'        => 'ReviewController@index',
            'title'     => awtTrans('التقييمات'),
            'icon'      => asset('assets/media/menuicon/newspaperw.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['reviews.index']
        ]);

        /********************************* SliderController start *********************************/
        Route::get('sliders', [
            'uses'      => 'SliderController@index',
            'as'        => 'sliders.index',
            'title'     => awtTrans('البنرات المتحركه'),
            'icon'      => asset('assets/media/menuicon/services.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['sliders.index', 'sliders.store', 'sliders.update', 'sliders.destroy','sliders.changeActive']
        ]);

        Route::post('sliders/store',['uses'=> 'SliderController@store','as'=> 'sliders.store','title'=> awtTrans('اضافة بنر')]);
        Route::post('sliders/{id}',['uses'=> 'SliderController@update','as'=> 'sliders.update','title'=> awtTrans('تعديل بنر')]);
        Route::delete('sliders/{id}',['uses'=> 'SliderController@destroy','as'=> 'sliders.destroy','title'=> awtTrans('حذف بنر')]);
        Route::post('sliders/active/change',['uses'=> 'SliderController@changeActive','as'=> 'sliders.changeActive','title'=> awtTrans('تنشيط')]);
        /********************************* SliderController end *********************************/

        /********************************* PageController start *********************************/
        Route::get('pages', [
            'uses'      => 'PageController@index',
            'as'        => 'pages.index',
            'title'     => awtTrans('الصفحات الرئيسيه'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['pages.index', 'pages.update']
        ]);
        Route::post('pages/{id}',['uses'=> 'PageController@update','as'=> 'pages.update','title'=> awtTrans('تعديل صفحه')]);
        /********************************* PageController end *********************************/

        /********************************* QuestionController start *********************************/
        Route::get('questions', [
            'uses'      => 'QuestionController@index',
            'as'        => 'questions.index',
            'title'     => awtTrans('الأسئله والأجوبه'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['questions.index', 'questions.store', 'questions.update', 'questions.destroy']
        ]);

        Route::post('questions/store',['uses'=> 'QuestionController@store','as'=> 'questions.store','title'=> awtTrans('اضافة سؤال')]);
        Route::post('questions/{id}',['uses'=> 'QuestionController@update','as'=> 'questions.update','title'=> awtTrans('تعديل سؤال')]);
        Route::delete('questions/{id}',['uses'=> 'QuestionController@destroy','as'=> 'questions.destroy','title'=> awtTrans('حذف سؤال')]);
        /********************************* QuestionController end *********************************/

        /********************************* ContactController start *********************************/
        Route::get('complaints', [
            'uses'      => 'ComplaintController@index',
            'as'        => 'complaints.index',
            'title'     => awtTrans('الشكاوي والمقترحات'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['complaints.index','complaints.update', 'complaints.destroy']
        ]);
        Route::post('complaints/{id}',['uses'=> 'ComplaintController@update','as'=> 'complaints.update','title'=> awtTrans('تعديل شكوي')]);
        Route::delete('complaints/{id}',['uses'=> 'ComplaintController@destroy','as'=> 'complaints.destroy','title'=> awtTrans('حذف شكوي')]);
        /********************************* ContactController end *********************************/

        /********************************* ContactController start *********************************/
        Route::get('contacts', [
            'uses'      => 'ContactController@index',
            'as'        => 'contacts.index',
            'title'     => awtTrans('تواصل معنا'),
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['contacts.index', 'contacts.update', 'contacts.destroy']
        ]);
        Route::post('contacts/{id}',['uses'=> 'ContactController@update','as'=> 'contacts.update','title'=> awtTrans('تعديل تواصل معنا')]);
        Route::delete('contacts/{id}',['uses'=> 'ContactController@destroy','as'=> 'contacts.destroy','title'=> awtTrans('حذف تواصل معنا')]);
        /********************************* ContactController end *********************************/

        /*------------ start Of coupon Controller ----------*/


        #index
        Route::get('coupons', [
            'uses'      => 'CouponController@index',
            'as'        => 'coupons.index',
            'title'     => awtTrans('الكوبونات'),
            'icon'      => asset('assets/media/menuicon/coupon.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['coupons.index', 'coupons.store', 'coupons.update', 'coupons.destroy']
        ]);

        #store
        Route::post('coupons/store', ['uses' => 'CouponController@store','as' => 'coupons.store','title'=> awtTrans('اضافة الكوبون')]);
        #update
        Route::post('coupons/{id}', ['uses' => 'CouponController@update','as'  => 'coupons.update','title'=> awtTrans('تعديل الكوبون')]);
        #delete
        Route::delete('coupons/{id}', ['uses' => 'CouponController@destroy','as' => 'coupons.destroy','title' => awtTrans('حذف الكوبون')]);
        /*------------ start Of reviews Controller ----------*/

        /********************************* ReportController start *********************************/
        Route::get('reports', [
            'uses'      => 'ReportController@index',
            'as'        => 'reports.index',
            'title'     => awtTrans('تقارير لوحة التحكم'),
            'icon'      => asset('assets/media/menuicon/surface1.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['reports.index', 'reports.delete']
        ]);
        Route::delete('reports/{id}',['uses'=> 'ReportController@destroy','as'=> 'reports.delete','title'=> awtTrans('حذف تقرير')]);
        /********************************* ReportController end *********************************/

        /********************************* ReportController start *********************************/
        Route::get('deductions', [
            'uses'      => 'DeductionController@index',
            'as'        => 'deductions.index',
            'title'     => awtTrans('الخصومات'),
            'icon'      => asset('assets/media/menuicon/coupon.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['deductions.index']
        ]);
        /********************************* ReportController end *********************************/

        /********************************* TransController start *********************************/
        Route::get('trans', [
            'uses'      => 'TransController@index',
            'as'        => 'trans.index',
            'title'     => awtTrans('الترجمات'),
            'icon'      => asset('assets/media/menuicon/route.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['trans.getLangDetails', 'trans.transInput']
        ]);
        Route::post('getLangDetails',['uses'=> 'TransController@getLangDetails','as'=> 'trans.getLangDetails','title'=> awtTrans('احضار ترجمه')]);
        Route::post('transInput',['uses'=> 'TransController@transInput','as'=> 'trans.transInput','title'=> awtTrans('حفظ ترجمه')]);
        /********************************* TransController end *********************************/

    });


});

});
//    ajax helper
Route::post('/ajax/getUser/{id}','AjaxController@getUser')->name('admin.ajax.getUser');
Route::post('/admin/branches','AjaxController@getBranches')->name('admin.ajax.getBranches');
Route::post('/admin/cities','AjaxController@getCities')->name('admin.ajax.getCities');
Route::post('/admin/regions','AjaxController@getRegions')->name('admin.ajax.getRegions');
Route::post('/admin/getCategories','AjaxController@getCategories')->name('admin.ajax.getCategories');
Route::post('/admin/getTechs','AjaxController@getTechs')->name('admin.ajax.getTechs');
Route::any('/admin/changeAccepted','AjaxController@changeAccepted')->name('ajax.changeAccepted');
Route::any('/admin/getItems','AjaxController@getItems')->name('admin.ajax.getItems');
Route::any('/admin/getSellers','AjaxController@getSellers')->name('admin.ajax.getSellers');
Route::any('/admin/getservices','AjaxController@getservices')->name('admin.ajax.getservices');

