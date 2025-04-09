<?php

namespace Mudtec\Ezimeeting\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\LoginLog;

class eziMeetingRegister
{

    protected $request;

    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event)
    {
        $user = $event->user;
        LoginLog::create([
            'description' => 'Register',
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $this->request->ip(),
            'login_at' => now(),
            'browser' => $this->request->server('HTTP_USER_AGENT'),
            'device' => $this->request->server('HTTP_X_DEVICE_TYPE'),
            'location' => $this->request->server('HTTP_X_LOCATION'),
        ]);
        Log::info("Register Registration : $user->id - $user->email");

        
    }
}