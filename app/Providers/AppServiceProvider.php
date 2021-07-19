<?php

namespace App\Providers;

use App\Entities\Category;
use App\Entities\City;
use App\Entities\ContactUs;
use App\Entities\Country;
use App\Entities\Lang;
use App\Entities\Offer;
use App\Entities\Page;
use App\Entities\Setting;
use App\Entities\Slider;
use App\Entities\Governorate;
use App\Models\User;
use App\Observers\Category as CategoryObserver;
use App\Observers\City as CityObserver;
use App\Observers\ContactUs as ContactUsObserver;
use App\Observers\Country as CountryObserver;
use App\Observers\Offer as OfferUsObserver;
use App\Observers\Page as PageObserver;
use App\Observers\Setting as SettingObserver;
use App\Observers\Slider as SliderUsObserver;
use App\Observers\Governorate as GovernorateObserver;
use App\Observers\User as UserObserver;
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
        User::observe(UserObserver::class);
        Country::observe(CountryObserver::class);
        City::observe(CityObserver::class);
        Category::observe(CategoryObserver::class);
        Page::observe(PageObserver::class);
        Setting::observe(SettingObserver::class);
        ContactUs::observe(ContactUsObserver::class);
    }
}
