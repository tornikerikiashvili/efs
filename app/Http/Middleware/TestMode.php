<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TestMode
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

        if(Session::get('beta') == 'yes'){
            return $next($request);
        }

        if(isset($request['beta']) && $request['beta'] == 'yes'){
            Session::put('beta', 'yes');
            return $next($request);
        }

        echo '<img src="http://www.reskita.co.id/webconstruction.png" style="display:block;max-width:100%;margin:auto;border-radius:10px">';
        exit;
        // if ($request->locale && !in_array($request->locale, array("en", "ka"))) {
        //     Session::put('locale', 'ka');
        //     App::setLocale('ka');
        //     return redirect('ka'.$_SERVER['REQUEST_URI'],301);
        // }
        return $next($request);
    }
}
