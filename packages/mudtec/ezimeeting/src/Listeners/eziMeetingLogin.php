<?php

namespace Mudtec\Ezimeeting\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\LoginLog;

class eziMeetingLogin
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
            'description' => 'Login',
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $this->request->ip(),
            'login_at' => now(),
            'browser' => $this->request->server('HTTP_USER_AGENT'),
            'device' => $this->request->server('HTTP_X_DEVICE_TYPE'),
            'location' => $this->request->server('HTTP_X_LOCATION'),
        ]);
        Log::info("Register Login : $user->id - $user->email");

        /*
        //check if user is linked to a corporation
        $corpUser = User::whereHas('corporations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();
        Log::info('CorpUser:', ['corpUser' => $corpUser]);

        if ($corpUser === null) {
            $intendedUrl = $this->request->session()->pull('url.intended', route('dashboard'));
            session(['redirect_after_details' => $intendedUrl]);
           
            Log::info('Intended URL:', ['url' => $intendedUrl]);
            
            return Redirect::route('corporationRegister');
        } //if (!$corporation) {

        Log::info("Proceeding to Dashboard");
        */
    }
}