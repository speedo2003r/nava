<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\SocialRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use UploadTrait;
    protected $settingRepo,$socialRepo;

    public function __construct(SettingRepository $setting,SocialRepository $social)
    {
        $this->settingRepo = $setting;
        $this->socialRepo = $social;
    }

    /***************************  get all settings  **************************/
    public function index()
    {
        $socials = $this->socialRepo->all();
        return view('admin.settings.index',compact('socials'));
    }
    /***************************  update setting  **************************/
    public function update(Request $request)
    {
        $data = $request['keys'];
        if($request->has('logo')) {
            if ($request['logo'] == 'remove'){
                $this->deleteFile(settings('logo'), 'settings');
                $logo = null;
                $request['keys'] = [];
            }else{
                $this->deleteFile(settings('logo'), 'settings');
                $logo = $this->uploadFile($request['logo'], 'settings');
            }
            $data = array_merge($request['keys'],['logo'=>$logo]);
        }
        $this->settingRepo->updateall($data);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }


}
