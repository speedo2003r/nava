<?php

namespace App\Observers;

use App\Entities\Country as CountryModel;
use App\Repositories\ReportRepository;

class Country
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the Country "created" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function created(CountryModel $country)
    {
        $text = 'قام ' . $this->user . '' . 'أضافة دوله ' . $country->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CountryModel "updated" event.
     *
     * @param  \App\Models\CountryModel  $country
     * @return void
     */
    public function updated(CountryModel $country)
    {
        $text = 'قام ' . $this->user . '' . 'تحديث دوله ' . $country->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CountryModel "deleted" event.
     *
     * @param  \App\Models\CountryModel  $country
     * @return void
     */
    public function deleted(CountryModel $country)
    {
        $text = 'قام ' . $this->user . '' . 'حذف دوله ' . $country->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CountryModel "restored" event.
     *
     * @param  \App\Models\CountryModel  $country
     * @return void
     */
    public function restored(CountryModel $country)
    {
        //
    }

    /**
     * Handle the CountryModel "force deleted" event.
     *
     * @param  \App\Models\CountryModel  $country
     * @return void
     */
    public function forceDeleted(CountryModel $country)
    {
        $text = 'قام ' . $this->user . '' . 'حذف دوله نهائيا ' . $country->title;
        $this->report->create(['desc' => $text]);
    }
}
