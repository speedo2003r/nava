<?php

namespace App\Http\Middleware\Admin;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AdminLang
{
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') AND in_array(Session::get('applocale'), ['ar','en'])) {
            App::setLocale(Session::get('applocale'));
            Carbon::setLocale(Session::get('applocale'));
        }
        else {
            App::setLocale('ar');
            Carbon::setLocale('ar');
        }
        return $next($request);
    }
}
