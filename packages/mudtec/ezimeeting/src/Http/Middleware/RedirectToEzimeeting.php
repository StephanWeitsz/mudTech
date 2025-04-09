<?php

namespace Mudtec\Ezimeeting\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectToEzimeeting
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if package should override default home/dashboard
            if ($this->shouldRedirectToEzimeeting($user)) {
                Log::info("Redirecting user to Ezimeeting home screen.");
                return redirect()->route('ezimeeting.home');


            }
        }

        return $next($request);
    }

    private function shouldRedirectToEzimeeting($user)
    {
        // Customize your condition: Example - redirect if user belongs to Ezimeeting
        return $user->hasRole('ezimeeting_user'); // Adjust this condition
    }
}