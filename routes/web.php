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
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::group(['middleware' => ['admin', 'check-role']], function () {

        /********************************* HomeController start *********************************/
        Route::get('dashboard', [
            'uses'  => 'HomeController@dashboard',
            'as'    => 'dashboard',
            'icon'  => asset('assets/media/menuicon/home.svg'),
            'title' => 'الرئيسيه',
            'type'  => 'parent'
        ]);
        /********************************* HomeController end *********************************/

        /********************************* RoleController start *********************************/
        Route::get('roles', [
            'uses'      => 'RoleController@index',
            'as'        => 'roles.index',
            'title'     => 'قائمة الصلاحيات',
            'icon'      => asset('assets/media/menuicon/document.svg'),
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
            'icon'      => asset('assets/media/menuicon/gear.svg'),
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
            'icon'      => asset('assets/media/menuicon/shield.svg'),
            'title'     => 'المستخدمين',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'admins.index', 'admins.store', 'admins.update', 'admins.delete',
                'clients.index', 'clients.store', 'clients.update', 'clients.delete',
                'technicians.index', 'technicians.store', 'technicians.update', 'technicians.delete', 'technicians.selectCategories',
                'companies.index', 'companies.store', 'companies.update', 'companies.delete', 'companies.images','companies.storeImages',
                'companies.technicians','companies.storeTechnicians','companies.updateTechnicians','companies.deleteTechnicians',
                'accountants.index', 'accountants.store', 'accountants.update', 'accountants.delete',
                'sendnotifyuser', 'changeStatus', 'addToWallet'
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
        # TechnicianController
        Route::get('technicians',['uses'=> 'TechnicianController@index','as'=> 'technicians.index','title'=> ' التقني','icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('technicians/store',['uses'=> 'TechnicianController@store','as'=> 'technicians.store','title'=> 'اضافة تقني']);
        Route::post('technicians/{id}',['uses'=> 'TechnicianController@update','as'=> 'technicians.update','title'=> 'تعديل تقني']);
        Route::delete('technicians/{id}',['uses'=> 'TechnicianController@destroy','as'=> 'technicians.delete','title'=> 'حذف تقني']);
        Route::post('technicians/select/categories',['uses'=> 'TechnicianController@selectCategories','as'=> 'technicians.selectCategories','title'=> 'اختيار التخصصات']);
        # CompanyController
        Route::get('companies',['uses'=> 'CompanyController@index','as'=> 'companies.index','title'=> ' الشركات','icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('companies/store',['uses'=> 'CompanyController@store','as'=> 'companies.store','title'=> 'اضافة شركه']);
        Route::post('companies/{id}',['uses'=> 'CompanyController@update','as'=> 'companies.update','title'=> 'تعديل شركه']);
        Route::delete('companies/{id}',['uses'=> 'CompanyController@destroy','as'=> 'companies.delete','title'=> 'حذف شركه']);

        Route::get('companies/images/{id}', ['uses' => 'CompanyController@images','as' => 'companies.images','title' => 'معرض الصور للشركه']);
        Route::post('companies/images/{id}', ['uses' => 'CompanyController@storeImages','as' => 'companies.storeImages','title' => 'حفظ معرض الصور للشركه']);

        Route::get('companies/technicians/{id}', ['uses' => 'TechnicianCompanyController@index','as' => 'companies.technicians','title' => 'التقنيين التابعين للشركه']);
        Route::post('companies/storeTechnicians/{id}', ['uses' => 'TechnicianCompanyController@store','as' => 'companies.storeTechnicians','title' => 'حفظ التقنيين التابعين للشركه']);
        Route::post('companies/updateTechnicians/{id}', ['uses' => 'TechnicianCompanyController@update','as' => 'companies.updateTechnicians','title' => 'تعديل التقنيين التابعين للشركه']);
        Route::delete('companies/deleteTechnicians', ['uses' => 'TechnicianCompanyController@delete','as' => 'companies.deleteTechnicians','title' => 'حذف التقنيين التابعين للشركه']);

        # AccountController
        Route::get('accountants',['uses'=> 'AccountantController@index','as'=> 'accountants.index','title'=> ' المحاسبين','icon'=> '<i class="nav-icon fa fa-users"></i>']);
        Route::post('accountants/store',['uses'=> 'AccountantController@store','as'=> 'accountants.store','title'=> 'اضافة محاسب']);
        Route::post('accountants/{id}',['uses'=> 'AccountantController@update','as'=> 'accountants.update','title'=> 'تعديل محاسب']);
        Route::delete('accountants/{id}',['uses'=> 'AccountantController@destroy','as'=> 'accountants.delete','title'=> 'حذف محاسب']);

        Route::post('send-notify-user',['uses'=> 'ClientController@sendnotifyuser','as'=> 'sendnotifyuser','title'=> 'ارسال اشعارات']);
        Route::post('change-status',['uses'=> 'ClientController@changeStatus','as'=> 'changeStatus','title'=> 'تغيير الحاله']);
        /********************************* all users controllers end *********************************/

        /********************************* CountriesController start *********************************/

        Route::get('country', [
            'as'        => 'country',
            'icon'      => asset('assets/media/menuicon/earth.svg'),
            'title'     => 'الاداره الجيوجرافيه',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'countries.index','countries.store', 'countries.update', 'countries.destroy',
                'cities.index', 'cities.store', 'cities.update', 'cities.destroy',
                'regions.index', 'regions.store', 'regions.update', 'regions.destroy',
                'branches.index','branches.create', 'branches.store','branches.edit', 'branches.update', 'branches.destroy',
            ]
        ]);

        Route::get('countries',['uses'=> 'CountriesController@index','as'=> 'countries.index','title'=> 'الدول','icon'=> '<i class="nav-icon fa fa-flag"></i>']);
        Route::post('countries/store',['uses'=> 'CountriesController@store','as'=> 'countries.store','title'=> 'اضافة دوله']);
        Route::post('countries/{id}',['uses'=> 'CountriesController@update','as'=> 'countries.update','title'=> 'تعديل دوله']);
        Route::delete('countries/{id}',['uses'=> 'CountriesController@destroy','as'=> 'countries.destroy','title'=> 'حذف دوله']);
        /********************************* CountriesController end *********************************/

        /********************************* CityController start *********************************/
        Route::get('cities', [
            'uses'      => 'CityController@index',
            'as'        => 'cities.index',
            'title'     => ' المدن',
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::post('cities/store',['uses'=> 'CityController@store','as'=> 'cities.store','title'=> 'اضافة مدينه']);
        Route::post('cities/{id}',['uses'=> 'CityController@update','as'=> 'cities.update','title'=> 'تعديل مدينه']);
        Route::delete('cities/{id}',['uses'=> 'CityController@destroy','as'=> 'cities.destroy','title'=> 'حذف مدينه']);
        /********************************* CityController end *********************************/

        /********************************* RegionController start *********************************/
        Route::get('regions', [
            'uses'      => 'RegionController@index',
            'as'        => 'regions.index',
            'title'     => ' المناطق',
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::post('regions/store',['uses'=> 'RegionController@store','as'=> 'regions.store','title'=> 'اضافة منطقه']);
        Route::post('regions/{id}',['uses'=> 'RegionController@update','as'=> 'regions.update','title'=> 'تعديل منطقه']);
        Route::delete('regions/{id}',['uses'=> 'RegionController@destroy','as'=> 'regions.destroy','title'=> 'حذف منطقه']);
        /********************************* RegionController end *********************************/

        /********************************* RegionController start *********************************/
        Route::get('branches', [
            'uses'      => 'BranchController@index',
            'as'        => 'branches.index',
            'title'     => 'المواقع',
            'icon'      => '<i class="nav-icon fa fa-flag"></i>',
        ]);
        Route::get('branches/create',['uses'=> 'BranchController@create','as'=> 'branches.create','title'=> 'صفحة اضافة موقع']);
        Route::post('branches/store',['uses'=> 'BranchController@store','as'=> 'branches.store','title'=> 'اضافة موقع']);
        Route::get('branches/{id}',['uses'=> 'BranchController@edit','as'=> 'branches.edit','title'=> 'صفحة تعديل موقع']);
        Route::post('branches/{id}',['uses'=> 'BranchController@update','as'=> 'branches.update','title'=> 'تعديل موقع']);
        Route::delete('branches/{id}',['uses'=> 'BranchController@destroy','as'=> 'branches.destroy','title'=> 'حذف موقع']);
        /********************************* RegionController end *********************************/

        /********************************* CategoryController start *********************************/
        Route::get('categories', [
            'uses'      => 'CategoryController@index',
            'as'        => 'categories.index',
            'title'     => ' الأقسام',
            'icon'      => asset('assets/media/menuicon/services.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => [
                'categories.index', 'categories.view', 'categories.store', 'categories.update', 'categories.destroy',
                'subcategories.index', 'subcategories.store', 'subcategories.update', 'subcategories.destroy','categories.changeCategoryAppear'
            ]
        ]);
        Route::get('categories/view',['uses'=> 'CategoryController@view','as'=> 'categories.view','title'=> 'عرض شجري للاقسام']);
        Route::post('categories/store',['uses'=> 'CategoryController@store','as'=> 'categories.store','title'=> 'اضافة قسم']);
        Route::post('categories/{id}',['uses'=> 'CategoryController@update','as'=> 'categories.update','title'=> 'تعديل قسم']);
        Route::delete('categories/{id}',['uses'=> 'CategoryController@destroy','as'=> 'categories.destroy','title'=> 'حذف قسم']);
        Route::post('categories/changeCategory/Appear',['uses'=> 'CategoryController@changeCategoryAppear','as'=> 'categories.changeCategoryAppear','title'=> 'تنشيط القسم']);

        /********************************* SubCategoryController start *********************************/
        Route::get('subcategories/{id}',['uses'=> 'SubCategoryController@index','as'=> 'subcategories.index','title'=> 'الأقسام الفرعيه']);
        Route::post('subcategories/store/{id}',['uses'=> 'SubCategoryController@store','as'=> 'subcategories.store','title'=> 'اضافة قسم فرعي']);
        Route::post('subcategories/{id}',['uses'=> 'SubCategoryController@update','as'=> 'subcategories.update','title'=> 'تعديل قسم فرعي']);
        Route::delete('subcategories/{id}',['uses'=> 'SubCategoryController@destroy','as'=> 'subcategories.destroy','title'=> 'حذف قسم فرعي']);
        /********************************* SubCategoryController end *********************************/

        /*------------ start Of services Controller ----------*/
        #season page
        Route::get('services', [
            'uses'      => 'ServiceController@index',
            'as'        => 'services.index',
            'title'     => 'خدمات',
            'icon'      => asset('assets/media/menuicon/customer-support.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child' => [
                'services.getFilterData',
                'services.store',
                'services.update',
                'services.destroy',
                'services.changeStatus',
                'parts.index',
                'parts.store',
                'parts.update',
                'parts.destroy',
            ]
        ]);
        Route::get('services/getFilterData', [
            'uses' => 'ServiceController@getFilterData',
            'as' => 'services.getFilterData',
            'title' => 'جلب بيانات الخدمات',
        ]);
        Route::post('services/store', [
            'uses' => 'ServiceController@store',
            'as' => 'services.store',
            'title' => 'اضافة خدمه',
        ]);
        Route::post('services/update/{id}', [
            'uses' => 'ServiceController@update',
            'as' => 'services.update',
            'title' => 'تحديث خدمه',
        ]);
        Route::post('services/changeStatus', [
            'uses' => 'ServiceController@changeStatus',
            'as' => 'services.changeStatus',
            'title' => 'تغيير حالة خدمه',
        ]);
        Route::delete('services/delete/{id}', [
            'uses' => 'ServiceController@destroy',
            'as' => 'services.destroy',
            'title' => 'حذف خدمه من الجدول',
        ]);
        Route::get('parts/{id}', [
            'uses' => 'PartsController@index',
            'as' => 'parts.index',
            'title' => 'قطع الغيار',
        ]);
        Route::post('parts/store', [
            'uses' => 'PartsController@store',
            'as' => 'parts.store',
            'title' => 'اضافة قطعة الغيار',
        ]);
        Route::post('parts/update/{id}', [
            'uses' => 'PartsController@update',
            'as' => 'parts.update',
            'title' => 'تحديث قطعة الغيار',
        ]);
        Route::delete('parts/delete/{id}', [
            'uses' => 'PartsController@destroy',
            'as' => 'parts.destroy',
            'title' => 'حذف قطعة الغيار',
        ]);

        /********************************* OrderController start *********************************/
        Route::get('orders', [
            'uses'      => 'OrderController@index',
            'as'        => 'orders.index',
            'title'     => ' الطلبات',
            'icon'      => asset('assets/media/menuicon/gear.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['orders.show', 'orders.assignTech', 'orders.servicesUpdate','orders.partsDestroy', 'orders.rejectOrder', 'orders.destroy']
        ]);

        Route::get('orders/{id}',['uses'=> 'OrderController@show','as'=> 'orders.show','title'=> 'مشاهدة طلب']);
        Route::post('orders/rejectOrder',['uses'=> 'OrderController@rejectOrder','as'=> 'orders.rejectOrder','title'=> 'رفض الطلب']);
        Route::post('orders/services/update',['uses'=> 'OrderController@servicesUpdate','as'=> 'orders.servicesUpdate','title'=> 'تعديل خدمه بالطلب']);
        Route::post('orders/assignTech',['uses'=> 'OrderController@assignTech','as'=> 'orders.assignTech','title'=> 'اختيار تقني']);
        Route::delete('orders/{id}',['uses'=> 'OrderController@destroy','as'=> 'orders.destroy','title'=> 'حذف طلب']);
        Route::delete('orders/parts/{id}',['uses'=> 'OrderController@partsDestroy','as'=> 'orders.partsDestroy','title'=> 'حذف قطعة الغيار']);
        /********************************* OrderController end *********************************/

        /*------------ start Of chat----------*/
        Route::get('chats', [
            'uses'      => 'ChatController@index',
            'as'        => 'chats.index',
            'title'     => ' سجل المحادثات',
            'icon'      => asset('assets/media/menuicon/chat.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['chats.index','chats.store','chats.users','chats.room','chats.privateRoom']
        ]);


        #store chats
        Route::post('chats/store', [
            'uses'      => 'ChatController@SaveMessage',
            'as'        => 'chats.store',
            'title'     => 'حفظ المحادثه'
        ]);

        #store chats
        Route::get('chats/room/{id}', [
            'uses'      => 'ChatController@ViewMessages',
            'as'        => 'chats.room',
            'title'     => 'مشاهدة المحادثه'
        ]);

        #store chats
        Route::get('chats/users', [
            'uses'      => 'ChatController@OtherUsers',
            'as'        => 'chats.users',
            'title'     => 'المستخدمين'
        ]);
        #store private chat
        Route::get('create-private-room/{user}', [
            'uses'      => 'ChatController@NewPrivateRoom',
            'as'        => 'chats.privateRoom',
            'title'     => 'اضافة غرفة دردشه'
        ]);

        /********************************* SliderController start *********************************/
        Route::get('sliders', [
            'uses'      => 'SliderController@index',
            'as'        => 'sliders.index',
            'title'     => ' البنرات المتحركه',
            'icon'      => asset('assets/media/menuicon/services.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['sliders.index', 'sliders.store', 'sliders.update', 'sliders.destroy','sliders.changeActive']
        ]);

        Route::post('sliders/store',['uses'=> 'SliderController@store','as'=> 'sliders.store','title'=> 'اضافة بنر']);
        Route::post('sliders/{id}',['uses'=> 'SliderController@update','as'=> 'sliders.update','title'=> 'تعديل بنر']);
        Route::delete('sliders/{id}',['uses'=> 'SliderController@destroy','as'=> 'sliders.destroy','title'=> 'حذف بنر']);
        Route::post('sliders/active/change',['uses'=> 'SliderController@changeActive','as'=> 'sliders.changeActive','title'=> 'تنشيط']);
        /********************************* SliderController end *********************************/

        /********************************* PageController start *********************************/
        Route::get('pages', [
            'uses'      => 'PageController@index',
            'as'        => 'pages.index',
            'title'     => ' الصفحات الرئيسيه',
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['pages.index', 'pages.update']
        ]);
        Route::post('pages/{id}',['uses'=> 'PageController@update','as'=> 'pages.update','title'=> 'تعديل صفحه']);
        /********************************* PageController end *********************************/

        /********************************* QuestionController start *********************************/
        Route::get('questions', [
            'uses'      => 'QuestionController@index',
            'as'        => 'questions.index',
            'title'     => ' الأسئله والأجوبه',
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['questions.index', 'questions.store', 'questions.update', 'questions.destroy']
        ]);

        Route::post('questions/store',['uses'=> 'QuestionController@store','as'=> 'questions.store','title'=> 'اضافة سؤال']);
        Route::post('questions/{id}',['uses'=> 'QuestionController@update','as'=> 'questions.update','title'=> 'تعديل سؤال']);
        Route::delete('questions/{id}',['uses'=> 'QuestionController@destroy','as'=> 'questions.destroy','title'=> 'حذف سؤال']);
        /********************************* QuestionController end *********************************/

        /********************************* ContactController start *********************************/
        Route::get('complaints', [
            'uses'      => 'ComplaintController@index',
            'as'        => 'complaints.index',
            'title'     => ' الشكاوي والمقترحات',
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['complaints.index','complaints.update', 'complaints.destroy']
        ]);
        Route::post('complaints/{id}',['uses'=> 'ComplaintController@update','as'=> 'complaints.update','title'=> 'تعديل شكوي']);
        Route::delete('complaints/{id}',['uses'=> 'ComplaintController@destroy','as'=> 'complaints.destroy','title'=> 'حذف شكوي']);
        /********************************* ContactController end *********************************/

        /********************************* ContactController start *********************************/
        Route::get('contacts', [
            'uses'      => 'ContactController@index',
            'as'        => 'contacts.index',
            'title'     => ' تواصل معنا',
            'icon'      => asset('assets/media/menuicon/document.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['contacts.index', 'contacts.update', 'contacts.destroy']
        ]);
        Route::post('contacts/{id}',['uses'=> 'ContactController@update','as'=> 'contacts.update','title'=> 'تعديل تواصل معنا']);
        Route::delete('contacts/{id}',['uses'=> 'ContactController@destroy','as'=> 'contacts.destroy','title'=> 'حذف تواصل معنا']);
        /********************************* ContactController end *********************************/

        /*------------ start Of coupon Controller ----------*/


        #index
        Route::get('coupons', [
            'uses'      => 'CouponController@index',
            'as'        => 'coupons.index',
            'title'     => ' الكوبونات',
            'icon'      => asset('assets/media/menuicon/coupon.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['coupons.index', 'coupons.store', 'coupons.update', 'coupons.destroy']
        ]);

        #store
        Route::post('coupons/store', ['uses' => 'CouponController@store','as' => 'coupons.store','title'=> 'اضافة الكوبون']);
        #update
        Route::post('coupons/{id}', ['uses' => 'CouponController@update','as'  => 'coupons.update','title'=> 'تعديل الكوبون']);
        #delete
        Route::delete('coupons/{id}', ['uses' => 'CouponController@destroy','as' => 'coupons.destroy','title' => 'حذف الكوبون']);
        /*------------ start Of reviews Controller ----------*/

        /********************************* ReportController start *********************************/
        Route::get('reports', [
            'uses'      => 'ReportController@index',
            'as'        => 'reports.index',
            'title'     => ' تقارير لوحة التحكم',
            'icon'      => asset('assets/media/menuicon/surface1.svg'),
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
            'icon'      => asset('assets/media/menuicon/route.svg'),
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['trans.getLangDetails', 'trans.transInput']
        ]);
        Route::post('getLangDetails',['uses'=> 'TransController@getLangDetails','as'=> 'trans.getLangDetails','title'=> 'احضار ترجمه']);
        Route::post('transInput',['uses'=> 'TransController@transInput','as'=> 'trans.transInput','title'=> 'حفظ ترجمه']);
        /********************************* TransController end *********************************/

    });


});

});
//    ajax helper
Route::post('/admin/cities','AjaxController@getCities')->name('admin.ajax.getCities');
Route::post('/admin/regions','AjaxController@getRegions')->name('admin.ajax.getRegions');
Route::post('/admin/getCategories','AjaxController@getCategories')->name('admin.ajax.getCategories');
Route::post('/admin/getTechs','AjaxController@getTechs')->name('admin.ajax.getTechs');
Route::any('/admin/changeAccepted','AjaxController@changeAccepted')->name('ajax.changeAccepted');
Route::any('/admin/getItems','AjaxController@getItems')->name('admin.ajax.getItems');
Route::any('/admin/getAds','AjaxController@getAds')->name('admin.ajax.getAds');
Route::any('/admin/getSellers','AjaxController@getSellers')->name('admin.ajax.getSellers');

