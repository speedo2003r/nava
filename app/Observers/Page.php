<?php

namespace App\Observers;

use App\Entities\Page as PageModel;
use App\Repositories\ReportRepository;

class Page
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the Page "created" event.
     *
     * @param  \App\Models\Page  $page
     * @return void
     */
    public function created(PageModel $page)
    {
        //
    }

    /**
     * Handle the PageModel "updated" event.
     *
     * @param  \App\Models\PageModel  $page
     * @return void
     */
    public function updated(PageModel $page)
    {
        $text = 'قام ' . $this->user . '' . 'بتعديل صفحه ' . $page->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the PageModel "deleted" event.
     *
     * @param  \App\Models\PageModel  $page
     * @return void
     */
    public function deleted(PageModel $page)
    {
        //
    }

    /**
     * Handle the PageModel "restored" event.
     *
     * @param  \App\Models\PageModel  $page
     * @return void
     */
    public function restored(PageModel $page)
    {
        //
    }

    /**
     * Handle the PageModel "force deleted" event.
     *
     * @param  \App\Models\PageModel  $page
     * @return void
     */
    public function forceDeleted(PageModel $page)
    {
        //
    }
}
