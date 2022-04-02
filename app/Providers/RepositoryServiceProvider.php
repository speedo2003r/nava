<?php

namespace App\Providers;

use App\Repositories\AdRepository;
use App\Repositories\AdRepositoryEloquent;
use App\Repositories\BannerRepository;
use App\Repositories\BannerRepositoryEloquent;
use App\Repositories\BranchRepository;
use App\Repositories\BranchRepositoryEloquent;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryEloquent;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\ComplaintRepository;
use App\Repositories\ComplaintRepositoryEloquent;
use App\Repositories\ContactUsRepository;
use App\Repositories\ContactUsRepositoryEloquent;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryEloquent;
use App\Repositories\CouponRepository;
use App\Repositories\CouponRepositoryEloquent;
use App\Repositories\CreditRepository;
use App\Repositories\CreditRepositoryEloquent;
use App\Repositories\DeviceRepository;
use App\Repositories\DeviceRepositoryEloquent;
use App\Repositories\ImageRepository;
use App\Repositories\ImageRepositoryEloquent;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationRepositoryEloquent;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\OrderServiceRepository;
use App\Repositories\OrderServiceRepositoryEloquent;
use App\Repositories\PageRepository;
use App\Repositories\PageRepositoryEloquent;
use App\Repositories\ProviderRepository;
use App\Repositories\ProviderRepositoryEloquent;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionRepositoryEloquent;
use App\Repositories\RegionRepository;
use App\Repositories\RegionRepositoryEloquent;
use App\Repositories\ReportRepository;
use App\Repositories\ReportRepositoryEloquent;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceRepositoryEloquent;
use App\Repositories\SettingRepository;
use App\Repositories\SettingRepositoryEloquent;
use App\Repositories\SliderRepository;
use App\Repositories\SliderRepositoryEloquent;
use App\Repositories\SocialRepository;
use App\Repositories\SocialRepositoryEloquent;
use App\Repositories\TechnicianRepository;
use App\Repositories\TechnicianRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepository::class           , UserRepositoryEloquent::class);
        $this->app->bind(CountryRepository::class           , CountryRepositoryEloquent::class);
        $this->app->bind(CityRepository::class           , CityRepositoryEloquent::class);
        $this->app->bind(SocialRepository::class           , SocialRepositoryEloquent::class);
        $this->app->bind(SettingRepository::class           , SettingRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class           , OrderRepositoryEloquent::class);
        $this->app->bind(ReportRepository::class           , ReportRepositoryEloquent::class);
        $this->app->bind(ContactUsRepository::class           , ContactUsRepositoryEloquent::class);
        $this->app->bind(PageRepository::class           , PageRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class           , CategoryRepositoryEloquent::class);
        $this->app->bind(ServiceRepository::class           , ServiceRepositoryEloquent::class);
        $this->app->bind(ImageRepository::class           , ImageRepositoryEloquent::class);
        $this->app->bind(DeviceRepository::class           , DeviceRepositoryEloquent::class);
        $this->app->bind(NotificationRepository::class           , NotificationRepositoryEloquent::class);
        $this->app->bind(ProviderRepository::class           , ProviderRepositoryEloquent::class);
        $this->app->bind(OrderServiceRepository::class           , OrderServiceRepositoryEloquent::class);
        $this->app->bind(TechnicianRepository::class           , TechnicianRepositoryEloquent::class);
        $this->app->bind(BranchRepository::class           , BranchRepositoryEloquent::class);
        $this->app->bind(RegionRepository::class           , RegionRepositoryEloquent::class);
        $this->app->bind(CouponRepository::class           , CouponRepositoryEloquent::class);
        $this->app->bind(CompanyRepository::class           , CompanyRepositoryEloquent::class);
        $this->app->bind(ComplaintRepository::class           , ComplaintRepositoryEloquent::class);
        $this->app->bind(SliderRepository::class           , SliderRepositoryEloquent::class);
        $this->app->bind(QuestionRepository::class           , QuestionRepositoryEloquent::class);

    }

    public function boot()
    {
        //
    }
}
