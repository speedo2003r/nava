<?php

namespace App\Observers;

use App\Entities\City as CityModel;
use App\Repositories\ReportRepository;

class City
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the City "created" event.
     *
     * @param  \App\Models\City  $city
     * @return void
     */
    public function created(CityModel $city)
    {
        $text = 'قام ' . $this->user . '' . 'أضافة مدينه ' . $city->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CityModel "updated" event.
     *
     * @param  \App\Models\CityModel  $city
     * @return void
     */
    public function updated(CityModel $city)
    {
        $text = 'قام ' . $this->user . '' . 'تحديث مدينه ' . $city->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CityModel "deleted" event.
     *
     * @param  \App\Models\CityModel  $city
     * @return void
     */
    public function deleted(CityModel $city)
    {
        $text = 'قام ' . $this->user . '' . 'حذف مدينه ' . $city->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CityModel "recreated" event.
     *
     * @param  \App\Models\CityModel  $city
     * @return void
     */
    public function restored(CityModel $city)
    {
        //
    }

    /**
     * Handle the CityModel "force deleted" event.
     *
     * @param  \App\Models\CityModel  $city
     * @return void
     */
    public function forceDeleted(CityModel $city)
    {
        $text = 'قام ' . $this->user . '' . 'حذف مدينه نهائيا ' . $city->title;
        $this->report->create(['desc' => $text]);
    }
}
