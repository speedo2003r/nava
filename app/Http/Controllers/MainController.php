<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index() {
        return view('welcome');
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
}
