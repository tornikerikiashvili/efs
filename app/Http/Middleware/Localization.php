<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        
        
        if ($request->locale && !in_array($request->locale, array("en", "ka"))) {
            Session::put('locale', 'ka');
            App::setLocale('ka');
            return redirect('ka'.$_SERVER['REQUEST_URI'],301);
        }
        
        // სესია არჭირდება მაგრამ მაინც იყოს სესიაშიც
        if (!Session::has('locale'))
         {
           Session::put('locale', $request->locale);
        }

        if(Session::get('locale') !== $request->locale){
            Session::put('locale', $request->locale);
        }
        
        App::setLocale($request->locale);


        return $next($request);

     
    }
}
