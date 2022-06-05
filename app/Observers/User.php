<?php

namespace App\Observers;

use App\Models\User as UserModel;
use App\Repositories\ReportRepository;
use App\Traits\UploadTrait;

class User
{
    use UploadTrait;
    public $report,$user;
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
        $this->user = auth()->check() ? auth()->user()['name'] : 'admin';
    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(UserModel $user)
    {
        $user->email = 'user'.$user['id'].'@nava.com';
        $user->save();
        $text = 'قام ' . $this->user . ' ب' . ' أضافة العميل ' . $user->name;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\UserModel  $user
     * @return void
     */
    public function updated(UserModel $user)
    {
        $text = 'قام ' . $this->user . ' ب' . ' تحديث العميل ' . $user->name;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(UserModel $user)
    {
        if($user['avatar'] != null){
            $this->deleteFile($user['avatar'],'users');
        }
        $text = 'قام ' . $this->user . ' ب' . ' حذف العميل ' . $user->name;
        $this->report->create(['desc' => $text]);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(UserModel $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(UserModel $user)
    {
        $text = 'قام ' . $this->user . ' ب' . ' حذف العميل نهائيا ' . $user->name;
        $this->report->create(['desc' => $text]);
    }
}
