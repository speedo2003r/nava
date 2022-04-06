<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;

class ApiLang
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        $lang = "ar";
        if(request()->header('lang') == null && !isset($request->lang)){
            $request->lang = $lang;
            request()->header('lang',$lang);
        }
        if(($request['lang'] != null && in_array($request['lang'],['ar','en'])) || ($request->header('lang') != null && in_array($request->header('lang'),['ar','en']))){
            $lang = $request->header('lang') != null ? $request->header('lang') : $request['lang'];
        }elseif(auth()->check()){
            $lang = auth()->user()->lang;
        }
        App::setLocale($lang);
        Carbon::setLocale($lang);
        return $next($request);
    }
}
