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
use Illuminate\Support\Facades\Notification;

class SendToDelegate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order,$users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order,$users)
    {
        $this->order = $order;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user){
            OrderTechnician::create([
                'order_id' => $this->order['id'],
                'technician_id' => $user['id'],
            ]);
        }

        Notification::send($this->users, new NewOrderDelegate($this->order));
    }
}
