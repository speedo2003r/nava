<?php

namespace App\Jobs;

use App\Entities\Order;
use App\Entities\OrderTechnician;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDelegateOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order_id,$user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->order_id = $order_id;
//        $this->user_id = $user_id;
    }

}
