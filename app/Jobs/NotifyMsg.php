<?php

namespace App\Jobs;

use App\Notifications\Notify;
use Illuminate\Support\Facades\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $users,protected $message,protected $sender_id)
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->users, new \App\Notifications\NotifyMsg($this->message,$this->sender_id));
    }
}
