<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ISocial;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    use UploadTrait;
    protected $socialRepo;

    public function __construct(ISocial $social)
    {
        $this->socialRepo = $social;
    }

    /***************************  update social  **************************/
    public function update(Request $request)
    {
        $data = $request['socials'];
        $this->socialRepo->updateall($data);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }
    /***************************  update social  **************************/
    public function store(Request $request)
    {
        $this->socialRepo->store($request->all());
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }


}
