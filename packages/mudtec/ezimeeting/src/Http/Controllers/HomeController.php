<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use  Mudtec\Ezimeeting\Mail\ContactFormSubmitted;

use Illuminate\Http\Request;
use Illuminate\View\View;

use Mudtec\Ezimeeting\Models\User;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        Log::info("eziMeeting Landing Page");
        $meetings = [];
        if (auth()->check()) {
            $user = User::find(Auth::id());
            //$meetings = $user->corporations()->with('departments.meetings')->get()->pluck('departments')->flatten()->pluck('meetings')->flatten();

            $meetings = $user->corporations()
                ->with(['departments.meetings' => function($query) {
                    $query->orderBy('scheduled_at', 'desc');
                }])
                ->get()
                ->pluck('departments')
                ->flatten()
                ->pluck('meetings')
                ->flatten()
                ->take(5);

            Log::info("User has access to " . count($meetings) . " meetings");
        }
        return view('ezimeeting::home', compact('meetings'));
    }

    public function about() {
        return view('ezimeeting::about');
    }

    public function contact() {
        return view('ezimeeting::contact');
    }
 
    public function contactSubmit() {

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
    
        Mail::to('your-email@example.com')->send(new ContactFormSubmitted($validated));
    
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function terms() {
        return view('ezimeeting::terms');
    }

    public function privacy() {
        return view('ezimeeting::privacy');
    }

    public function faq() {
        return view('ezimeeting::faq');
    }

}

