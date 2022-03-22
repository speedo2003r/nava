<?php

namespace App\Jobs;

use App\Entities\OrderTechnician;
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
    public $order_id,$user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id,$user_id)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        OrderTechnician::create([
            'order_id' => $this->order_id,
            'technician_id' => $this->user_id,
        ]);
        $user = \App\Models\User::find($this->user_id);
        Artisan::call('tech:notify', [
          'tech' => $user, 'order' => $this->order
        ]);

    }
}
