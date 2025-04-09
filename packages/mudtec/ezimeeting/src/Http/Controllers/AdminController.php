<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Support\Facades\Gate;

use Mudtec\Ezimeeting\Models\User;

class AdminController extends Controller
{
    public function index()
    {

        if(verify_user('admin')) {
            return "You can access this section.";
        } else {
            return "Access denied.";
        }

    }

    public function meetingstatus() {
        return view('ezimeeting::admin.meeting-status');
    }

    public function meetinginterval() {
        return view('ezimeeting::admin.meeting-interval');
    }

    public function meetinglocation() {
        return view('ezimeeting::admin.meeting-location');
    }

    public function meetingdelegaterole() {
        return view('ezimeeting::admin.meeting-delegate-role');
    }

    public function meetingattendeestatus() {
        return view('ezimeeting::admin.meeting-attendee-status');
    }

    public function meetingminuteactionstatus() {
        return view('ezimeeting::admin.meeting-minute-action-status');
    }


}

