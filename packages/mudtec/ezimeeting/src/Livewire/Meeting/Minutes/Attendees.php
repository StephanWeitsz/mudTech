<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting\Minutes
;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\Role;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingDelegate;

use Mudtec\Ezimeeting\Models\MeetingAttendeeStatus;
use Mudtec\Ezimeeting\Models\MeetingAttendee;

class Attendees extends Component
{
    public $search;

    public $meetingId;
    public $minuteId;
    public $delegates;
    public $attendeeStatuses;
    public $assignedAttendeeStatus;
        
    public $page_heading = 'Meeting Attendees';
    public $page_sub_heading = 'Set attendee Status';

    public function mount($meetingId, $minuteId) 
    {

        $this->meetingId = $meetingId;
        $this->minuteId = $minuteId;

        if(empty($minuteId))
            $this->page_sub_heading = 'Capture meeting munites first';
        else {
            $this->attendeeStatuses = MeetingAttendeeStatus::all();
            $this->initializeAssignedStatus();
        }
    }

    public function initializeAssignedStatus()
    {
        $this->delegates = MeetingDelegate::where('meeting_id', $this->meetingId)
        ->where('is_active', true)
        ->orderBy('delegate_name')
        ->get();

        foreach ($this->delegates as $attendee) {
            $attendeeStatus = MeetingAttendee::where('minute_id', $this->minuteId)
                ->where('meeting_delegate_id', $attendee->id)
                ->value('meeting_attendee_status_id');

            $this->assignedAttendeeStatus[$attendee->id] = $attendeeStatus ?? 1;
        }        
    }

    public function setStatus($delegateId, $statusId)
    {
        $delegate = MeetingDelegate::find($delegateId);
        if ($delegate) {
            MeetingAttendee::updateOrCreate(
                [
                    'minute_id' => $this->minuteId,
                    'meeting_delegate_id' => $delegateId,
                ],
                [
                    'meeting_attendee_status_id' => $statusId,
                ]
            );
            $this->assignedAttendeeStatus[$delegateId] = $statusId;
        } else {
            session()->flash('error', 'Delegate not found.');
        }
    }

    public function render()
    {
        $this->delegates = MeetingDelegate::where('meeting_id', $this->meetingId)
        ->when($this->search, function($query) {
            $query->where(function($query) {
                $query->whereRaw('LOWER(delegate_name) LIKE ?', ['%' . mb_strtolower($this->search) . '%'])
                      ->orWhereRaw('LOWER(delegate_email)', 'LIKE ?', ['%' . mb_strtolower($this->search) . '%']);
            });
        })
        ->orderBy('delegate_name')
        ->get();
        
        return view('ezimeeting::livewire.meeting.minutes.attendees');
    }
}