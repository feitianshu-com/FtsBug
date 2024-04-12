<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en'; // set en as the fallback locale
        if ($request->segment(1) == 'zh_CN') { // if the route starts with /es/* set locale to E
            $locale = 'zh_CN';
            session(['lang' => $locale]);
            config(['app.locale' => 'zh_CN']);
        }
        else if($request->segment(1) == 'en'){
            config(['app.locale' => 'en']);
        }
        else if(session('lang') == 'zh_CN'){
            config(['app.locale' => 'zh_CN']);
        }
        else{
            config(['app.locale' => 'en']);
        }
        //set the derived locale
        // app()->setLocale($locale);
        // app()->setLocale($request->segment(1));
        // URL::defaults(['locale' => $request->segment(1)]);
        return $next($request);
    }
}
