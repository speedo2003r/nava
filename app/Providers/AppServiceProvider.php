<?php

namespace App\Providers;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\City;
use App\Entities\Company;
use App\Entities\Complaint;
use App\Entities\ContactUs;
use App\Entities\Country;
use App\Entities\Coupon;
use App\Entities\Lang;
use App\Entities\OrderBill;
use App\Entities\Page;
use App\Entities\Question;
use App\Entities\Region;
use App\Entities\Service;
use App\Entities\Setting;
use App\Entities\Slider;
use App\Entities\Technician;
use App\Models\User;
use App\Observers\Category as CategoryObserver;
use App\Observers\City as CityObserver;
use App\Observers\ContactUs as ContactUsObserver;
use App\Observers\Country as CountryObserver;
use App\Observers\Page as PageObserver;
use App\Observers\Setting as SettingObserver;
use App\Observers\User as UserObserver;
use App\Observers\Branch as BranchObserver;
use App\Observers\Company as CompanyObserver;
use App\Observers\Complaint as ComplaintObserver;
use App\Observers\Coupon as CouponObserver;
use App\Observers\OrderBill as OrderBillObserver;
use App\Observers\Question as QuestionObserver;
use App\Observers\Region as RegionObserver;
use App\Observers\Service as ServiceObserver;
use App\Observers\Technician as TechnicianObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin/layout/master',function($view){
            $view->with('logo', dashboard_url('images/nafalogo1.png'));
            $view->with('langs', Lang::all());
        });
        Paginator::useBootstrap();
        Branch::observe(BranchObserver::class);
        Company::observe(CompanyObserver::class);
        Complaint::observe(ComplaintObserver::class);
        Coupon::observe(CouponObserver::class);
        OrderBill::observe(OrderBillObserver::class);
        Question::observe(QuestionObserver::class);
        Region::observe(RegionObserver::class);
        Service::observe(ServiceObserver::class);
        Technician::observe(TechnicianObserver::class);
        User::observe(UserObserver::class);
        Country::observe(CountryObserver::class);
        City::observe(CityObserver::class);
        Category::observe(CategoryObserver::class);
        Page::observe(PageObserver::class);
        Setting::observe(SettingObserver::class);
        ContactUs::observe(ContactUsObserver::class);
    }
}
