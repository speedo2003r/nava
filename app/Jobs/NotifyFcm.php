<?php

namespace App\Jobs;

use App\Entities\Notification;
use App\Entities\QrPrintedBy;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotifyFcm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $from;
    private $to;
    private $message_ar;
    private $message_en;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from,$to,$message_ar,$message_en)
    {
        $this->from = $from;
        $this->to = $to;
        $this->message_ar = $message_ar;
        $this->message_en = $message_en;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->to['id']);
        if($user){
            $notification = new Notification();
            $notification->to_id        = $this->to['id'];
            $notification->from_id        = $this->from['id'];
            $notification->message_ar   = $this->message_ar;
            $notification->message_en   = $this->message_en;
            $notification->type         = 'notify';
            $notification->seen         = 0;
            $notification->save();
        }

    }
}
