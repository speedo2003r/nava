<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /***************** show login form *****************/

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|string',
            'fcm_token'  => 'nullable',
        ]);

        $remember = true;
        if (auth()->guard()->attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
            auth()->user()->devices()->create(['device_type'=>'web','device_id' => $request['fcm_token']]);
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('show.login')->withErrors('تحقق من صحة البيانات المدخلة');

        }

    }


    /**************** logout *****************/
    public function logout()
    {
        if(count(auth()->user()->devices) > 0){
            foreach (auth()->user()->devices as $device){
                $device->delete();
            }
        }
        auth()->guard()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('admin.login'));
    }



}
