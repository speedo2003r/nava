<?php

namespace App\Observers;

use App\Entities\Service as CategoryModel;
use App\Repositories\ReportRepository;

class Service
{
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(CategoryModel $category)
    {
        $text = 'قام ' . $this->user . '' . ' أضافة خدمه ' . $category->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CategoryModel "updated" event.
     *
     * @param  \App\Models\CategoryModel  $category
     * @return void
     */
    public function updated(CategoryModel $category)
    {
        $text = 'قام ' . $this->user . '' . ' تحديث خدمه ' . $category->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CategoryModel "deleted" event.
     *
     * @param  \App\Models\CategoryModel  $category
     * @return void
     */
    public function deleted(CategoryModel $category)
    {
        $text = 'قام ' . $this->user . '' . ' حذف خدمه ' . $category->title;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the CategoryModel "restored" event.
     *
     * @param  \App\Models\CategoryModel  $category
     * @return void
     */
    public function restored(CategoryModel $category)
    {
        //
    }

    /**
     * Handle the CategoryModel "force deleted" event.
     *
     * @param  \App\Models\CategoryModel  $category
     * @return void
     */
    public function forceDeleted(CategoryModel $category)
    {
        $text = 'قام ' . $this->user . '' . 'حذف خدمه نهائيا ' . $category->title;
        $this->report->create(['desc' => $text]);
    }
}
