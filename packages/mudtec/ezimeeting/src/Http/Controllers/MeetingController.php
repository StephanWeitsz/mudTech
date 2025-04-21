<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;

class MeetingController extends Controller
{
    public function new() {
        return view('ezimeeting::meeting.new');
    }

    public function delegates($corpId, $meetingId) {
        if (is_null($meetingId) || is_null($corpId)) {
            //dd("Required session variables are missing.");
            return redirect()->route('errorPage')->with('error', 'Required session variables are missing.');
        }
        return view('ezimeeting::meeting.delegates.view', compact('meetingId', 'corpId'));
    }

    public function list() {
        return view('ezimeeting::meeting.list');
    }

    public function view($meetingId) {
        $minutesId = "";
        $meeting = Meeting::find($meetingId);
        $dep_id = $meeting->department_id;
        $corpId = Department::whereHas('corporation', function ($query) use ($dep_id) {
            $query->where('id', $dep_id);
        })->pluck('corporation_id')->first();
        return view('ezimeeting::meeting.view', compact('meetingId', 'minutesId', 'corpId'));
    }

    public function edit($meetingId) {
        $meeting = Meeting::find($meetingId);
        $dep_id = $meeting->department_id;
        $corpId = Department::whereHas('corporation', function ($query) use ($dep_id) {
            $query->where('id', $dep_id);
        })->pluck('corporation_id')->first();
        return view('ezimeeting::meeting.edit', compact('meetingId', 'corpId'));
    }

    public function MinutesList($meetingId) {
        return view('ezimeeting::meeting.minutes.list', compact('meetingId'));
    }

    public function MinuteList($meetingId) {
        $minutesId = "";
        return view('ezimeeting::meeting.minute.list', compact('meetingId', 'minutesId'));
    }

    public function MinuteDetail($meetingId, $minutesId) {       
        return view('ezimeeting::meeting.minute.detail', compact('meetingId', 'minutesId'));
    }

    public function ownerList() {
        $ownerId = auth()->user()->id;
        return view('ezimeeting::meeting.list', compact('ownerId'));
    }

    public function MeetingCalendar() {
        return view('ezimeeting::meeting.calendar.view');
    }
}