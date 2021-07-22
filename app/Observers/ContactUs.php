<?php

namespace App\Observers;

use App\Entities\ContactUs as ContactUsModel;
use App\Repositories\ReportRepository;

class ContactUs
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the ContactUs "created" event.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return void
     */
    public function created(ContactUsModel $contactUs)
    {
        //
    }

    /**
     * Handle the ContactUsModel "updated" event.
     *
     * @param  \App\Models\ContactUsModel  $contactUs
     * @return void
     */
    public function updated(ContactUsModel $contactUs)
    {
        $text = 'قام ' . $this->user . '' . ' بقراءة رساله ' . $contactUs->name;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the ContactUsModel "deleted" event.
     *
     * @param  \App\Models\ContactUsModel  $contactUs
     * @return void
     */
    public function deleted(ContactUsModel $contactUs)
    {
        $text = 'قام ' . $this->user . '' . ' بحذف رساله ' . $contactUs->name;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the ContactUsModel "restored" event.
     *
     * @param  \App\Models\ContactUsModel  $contactUs
     * @return void
     */
    public function restored(ContactUsModel $contactUs)
    {
        //
    }

    /**
     * Handle the ContactUsModel "force deleted" event.
     *
     * @param  \App\Models\ContactUsModel  $contactUs
     * @return void
     */
    public function forceDeleted(ContactUsModel $contactUs)
    {
        $text = 'قام ' . $this->user . '' . ' بحذف رساله نهائيا ' . $contactUs->name;
        $this->report->create(['desc' => $text]);
    }
}
