<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Support\Facades\Response;

class cors
{
    public function handle($request, Closure $next)
    {
        $headers = [
            "Access-Control-Allow-Origin"  => "*",
            "Access-Control-Allow-Headers" => "X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method",
            "Access-Control-Allow-Methods" => "POST, GET, OPTIONS, PUT, DELETE",
            "Content-Type"                 => "application/json,form-data,charset=UTF-8",
            "Access-Control-Max-Age"       => "1000"
        ];
        
        
        # for jwt
        if($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);
        
        foreach($headers as $key => $value)
            $response->header($key, $value);
        
        return $response;
    }
}
