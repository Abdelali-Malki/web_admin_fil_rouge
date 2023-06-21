<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;

class Installcheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function  handle($request, Closure $next)
    {
        $isInstall = \Request::route()->getName();

        if($isInstall=='install' && env("DB_HOST") != "" && env("DB_DATABASE") !="" && env("DB_USERNAME") !=""){
            return redirect('/home');
        }
        else if ($isInstall !='install' && (env("DB_HOST") == "" || env("DB_DATABASE") =="" || env("DB_USERNAME") =="" )) {
            return redirect('install');
        }
            return $next($request);
    }

}
