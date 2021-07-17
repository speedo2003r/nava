<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Category;
use App\Entities\Country;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /***************** dashboard *****************/
    public function dashboard()
    {
        $allUsers        = User::get();
        $countAdmins     = $allUsers->where('user_type', 'admin')->count();
        $countClients    = $allUsers->where('user_type', 'client')->count();
        $countCategories = Category::count();
        $countCountries  = Country::count();
        return view('admin.dashboard.index',compact('countAdmins','countClients','countCategories','countCountries'));
    }

}
