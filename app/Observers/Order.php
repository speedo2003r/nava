<?php

namespace App\Observers;

use App\Entities\Order as OrderModel;
use App\Repositories\ReportRepository;

class Order
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
     * @param  \App\Models\Category  $order
     * @return void
     */
    public function created(OrderModel $order)
    {
        //
    }

    /**
     * Handle the OrderModel "updated" event.
     *
     * @param  \App\Models\OrderModel  $order
     * @return void
     */
    public function updated(OrderModel $order)
    {
        //
    }

    /**
     * Handle the OrderModel "deleted" event.
     *
     * @param  \App\Models\OrderModel  $order
     * @return void
     */
    public function deleted(OrderModel $order)
    {
        $text = 'قام ' . $this->user . '' . 'حذف طلب ' . $order->id;
        $this->report->store(['desc' => $text]);
    }

    /**
     * Handle the OrderModel "restored" event.
     *
     * @param  \App\Models\OrderModel  $order
     * @return void
     */
    public function restored(OrderModel $order)
    {
        //
    }

    /**
     * Handle the OrderModel "force deleted" event.
     *
     * @param  \App\Models\OrderModel  $order
     * @return void
     */
    public function forceDeleted(OrderModel $order)
    {
        $text = 'قام ' . $this->user . '' . 'حذف طلب نهائيا ' . $order->id;
        $this->report->store(['desc' => $text]);
    }
}
