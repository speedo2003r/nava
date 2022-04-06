<?php
namespace App\Http\Controllers;

use App\Entities\ContactUs;
use App\Entities\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index() {
        return view('welcome');
    }
    public function contact(Request $request) {
        $this->validate($request,[
            'name' => 'required|max:191',
            'email' => 'required|email',
            'phone' => 'required|digits_between:9,13',
            'message' => 'required|string',
        ]);
        $data = array_filter($request->all());
        ContactUs::create($data);
        $msg = app()->getLocale() == 'ar' ? 'تم الارسال بنجاح' : 'successfully sent';
        return back()->with('success',$msg);
    }
    public function changeLanguage($lang)
    {
        Session::put('applocale',$lang);
        return redirect()->back();
    }
    /**************** show login form *****************/
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**************** show login form *****************/
    public function policy()
    {
        $page = Page::find(2);
        return view('policy',compact('page'));
    }
}
