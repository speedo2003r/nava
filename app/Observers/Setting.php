<?php

namespace App\Observers;

use App\Entities\Setting as SettingModel;
use App\Repositories\ReportRepository;

class Setting
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the Setting "created" event.
     *
     * @param  \App\Models\Setting  $setting
     * @return void
     */
    public function created(SettingModel $setting)
    {
        $text = 'قام ' . $this->user . '' . 'بأضافة اعداد ' . $setting->key;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the SettingModel "updated" event.
     *
     * @param  \App\Models\SettingModel  $setting
     * @return void
     */
    public function updated(SettingModel $setting)
    {
        $text = 'قام ' . $this->user . '' . 'بتحديث اعداد ' . $setting->key;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the SettingModel "deleted" event.
     *
     * @param  \App\Models\SettingModel  $setting
     * @return void
     */
    public function deleted(SettingModel $setting)
    {
        $text = 'قام ' . $this->user . '' . 'بحذف اعداد ' . $setting->key;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the SettingModel "restored" event.
     *
     * @param  \App\Models\SettingModel  $setting
     * @return void
     */
    public function restored(SettingModel $setting)
    {
        //
    }

    /**
     * Handle the SettingModel "force deleted" event.
     *
     * @param  \App\Models\SettingModel  $setting
     * @return void
     */
    public function forceDeleted(SettingModel $setting)
    {
        $text = 'قام ' . $this->user . '' . 'بحذف اعداد نهائيا ' . $setting->key;
        $this->report->create(['desc' => $text]);
    }
}
