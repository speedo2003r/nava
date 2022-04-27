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
            if($request['fcm_token'] != null){
                if(session('fcm_token')){
                    auth()->user()->devices()->where('device_id',session('fcm_token'))->delete();
                }
                auth()->user()->devices()->create(['device_type'=>'web','device_id' => $request['fcm_token']]);
                session()->put(['fcm_token'=>$request['fcm_token']]);
            }
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('show.login')->withErrors('تحقق من صحة البيانات المدخلة');

        }

    }


    /**************** logout *****************/
    public function logout()
    {
        if(session('fcm_token')){
            auth()->user()->devices()->where('device_id',session('fcm_token'))->delete();
        }

        auth()->guard()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('admin.login'));
    }



}
