<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;


use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingStatus;

class MeetingDetail extends Component
{

    public $meeting;
    public $meetingState;

    public $meeting_description;
    public $meeting_text;
    public $meeting_purpose;
    public $meeting_department_id;
    public $meeting_scheduled_at;
    public $meeting_duration;
    public $meeting_interval_id;
    public $meeting_location_id;
    public $meeting_status_id;
    public $meeting_exturnal_url;
    public $meeting_created_by_user_id;

    public $departments;
    public $meeting_statuses;
    public $meeting_intervals;
    public $meeting_locations;
    public $corpUsers;

    public $page_heading = 'Meeting Detail';
    public $page_sub_heading = 'Detailed View of the Meeting';

    public function mount($meetingId, $state) 
    {
        $this->meetingState = $state;
        $this->meeting = Meeting::find($meetingId);

        $this->meeting_description = $this->meeting->description;
        $this->meeting_text = $this->meeting->text;
        $this->meeting_purpose = $this->meeting->purpose;
        $this->meeting_department_id = $this->meeting->department_id;
        $this->meeting_scheduled_at = $this->meeting->scheduled_at;
        $this->meeting_duration = $this->meeting->duration;
        $this->meeting_interval_id = $this->meeting->meeting_interval_id;
        $this->meeting_location_id = $this->meeting->meeting_location_id;
        $this->meeting_status_id = $this->meeting->meeting_status_id;
        $this->meeting_exturnal_url = $this->meeting->external_url;
        $this->meeting_created_by_user_id = $this->meeting->created_by_user_id;

        //dd($this->meeting);

        $this->meeting_scheduled_at = optional($this->meeting->scheduled_at)->format('Y-m-d\TH:i');
        //dd($this->meeting_scheduled_at);

        if($state == "edit") {
            $this->page_heading = 'Meeting Edit';
            $this->page_sub_heading = 'Edit the Meeting Details';
            
            $corpName = get_corporation_name($this->meeting->department_id);
            //$this->departments = Corporation::where('name', $corpName)->first()->departments()->get();
            $this->departments = Department::whereHas('corporation', function ($query) use ($corpName) {
                $query->where('name', $corpName);
            })->get();

            $this->meeting_statuses = MeetingStatus::all();
            $this->meeting_intervals = MeetingInterval::all();
            //dd($this->meeting_intervals);

            $this->meeting_locations = MeetingLocation::whereHas('corporation', function ($query) use ($corpName) {
                $query->where('name', $corpName);
            })->get();
            //dd($this->meeting_locations);

            $this->corpUsers = User::whereHas('corporations', function ($query) use ($corpName) {
                $query->where('name', $corpName);
            })->get();
            //dd($this->corpUsers);
        }
        else {
            $this->page_heading = 'Meeting Detail';
            $this->page_sub_heading = 'Detailed View of the Meeting';
        }
    }

    public function updateMeeting() {
        $validatedData = $this->validate([
           'meeting_description' => ['required','max:255'],
           'meeting_text' => ['required','max:255'],
           'meeting_purpose' => ['required','max:255'],
           'meeting_department_id' => ['required'],
           'meeting_scheduled_at' => ['required', 'date_format:Y-m-d\TH:i'],
           'meeting_duration' => ['required', 'integer','min:1'],
           'meeting_interval_id' => ['required'],
           'meeting_location_id' => ['required'],
           'meeting_status_id' => ['required'],
           'meeting_exturnal_url' => ['nullable'],
           'meeting_created_by_user_id' => ['required']
        ]);

        $this->meeting->description = $this->meeting_description;
        $this->meeting->text = $this->meeting_text;
        $this->meeting->purpose = $this->meeting_purpose;
        $this->meeting->department_id = $this->meeting_department_id;
        $this->meeting->scheduled_at = $this->meeting_scheduled_at;
        $this->meeting->duration = $this->meeting_duration;
        $this->meeting->meeting_interval_id = $this->meeting_interval_id;
        $this->meeting->meeting_location_id = $this->meeting_location_id;
        $this->meeting->meeting_status_id = $this->meeting_status_id;
        $this->meeting->external_url = $this->meeting_exturnal_url;
        $this->meeting->created_by_user_id = $this->meeting_created_by_user_id;
        $this->meeting->save();
        session()->flash('success', 'Meeting details updated successfully.');

    }

    public function exitEditMeeting() {
        session()->forget('success');
        return redirect()->route('meetingList');
    }

    public function setMeetingStatus($status) {
        
        $meetingStatus = MeetingStatus::where('description',$status)->first();
        if($meetingStatus == null) {
            session()->flash('error', 'Meeting status not found.');
            return;
        }
        $this->meeting->update(['meeting_status_id' => $meetingStatus->id]);
        $this->meeting_status_id = $meetingStatus->id;
        session()->flash('success', 'Meeting status updated to ' . $status);
    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.meeting-detail');
    }

}