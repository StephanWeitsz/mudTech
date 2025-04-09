<?php

namespace Mudtec\Ezimeeting\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;

class CheckCorporationMembership
{
    public function handle(Request $request, Closure $next)
    {


        /*
        if(Auth::check()) {
            $user = User::find(Auth::id());
            
            if ($user && !$user->corporations()->exists()) {
                
                if (!$request->is('corporation/register')) {
                   
                    //return redirect()->route('corporationRegister');
                    return response()->view('ezimeeting::admin.corporations.corporationRegister');
                }
               
            }
           
        }
        */

        
        return $next($request);
    }
}