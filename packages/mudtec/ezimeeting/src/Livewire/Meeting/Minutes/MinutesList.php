<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting\Minutes;

use Livewire\Component;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingMinute;

class MinutesList extends Component
{
    public $minuteId;

    public $meetingId;
    public $meetingStatus;
    public $meetingMinutes;

    public $page_heading = 'Meeting Minutes';
    public $page_sub_heading = 'List';

    public function mount($meetingId) 
    {
        $this->meetingMinutes = MeetingMinute::where('meeting_id', $meetingId)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function edit($meetingId, $minuteId)
    {
        return redirect()->route('viewMeetingMinutes', ['meeting' => $meetingId, 'minute' => $minuteId]);
    }

    public function back() {
        return redirect()->route('meetingView', ['meeting' => $this->meetingId]);
    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.minutes.minutes-list', ['meetingId' => $this->meetingId]);
    }

}