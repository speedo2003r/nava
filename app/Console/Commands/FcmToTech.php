<?php

namespace App\Console\Commands;

use App\Traits\NotifyTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FcmToTech extends Command
{
    use NotifyTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tech:notify {tech} {order}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send fcm to tech';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $content_ar = 'هناك طلب جديد رقم '.$this->argument('order')['id'].' مناسب لك';
        $content_en = 'A new order number '.$this->argument('order')['id'].' is right for you';
        $notification = new Notification();
        $notification->to_id        = $this->argument('tech')['id'];
        $notification->from_id        = $this->argument('order')['user_id'];
        $notification->message_ar   = $content_ar;
        $notification->message_en   = $content_en;
        $notification->type         = 'order';
        $notification->order_id     = $this->argument('order')['id'];
        $notification->order_status = $this->argument('order')['status'];
        $notification->seen         = 0;
        $notification->save();
        $data['title'] = app()->getLocale() == 'ar' ? 'طلب جديد': 'new order';
        $data['body'] = app()->getLocale() == 'ar' ? $content_ar: $content_en;
        if($this->argument('tech')->Devices){
            foreach ($this->argument('tech')->Devices as $device) {
                if($device->device_id != null){
                    $this->send_fcm($device->device_id, $data, $device->device_type);
                }
            }
        }

//        Log::debug('dispatched complete '.$notification['id']);
    }
}
