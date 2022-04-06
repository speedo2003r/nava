<?php

namespace App\Jobs;

use App\Entities\OrderTechnician;
use App\Notifications\Api\NewOrderDelegate;
use http\Client\Curl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SendToDelegate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order,$user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order,$user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        OrderTechnician::create([
            'order_id' => $this->order['id'],
            'technician_id' => $this->user['id'],
        ]);
        $title_ar = 'طلب جديد';
        $title_en = 'new order';
        $content_ar = 'هناك طلب جديد رقم '.$this->order['order_num'].' مناسب لك';
        $content_en = 'A new order number '.$this->order['order_num'].' is right for you';
        $this->user->notify(new NewOrderDelegate($title_ar,$title_en,$content_ar,$content_en,$this->order));
    }
}
