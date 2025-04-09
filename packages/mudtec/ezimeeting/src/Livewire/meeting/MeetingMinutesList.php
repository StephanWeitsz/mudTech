<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingMinute;

class MeetingMinutesList extends Component
{
    public $minutesId;

    public $meetingId;
    public $meetingStatus;
    public $meetingMinutes;

    public $page_heading = 'Meeting List';

    public function mount($meetingId, $minutesId) 
    {

    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.meeting-minutes-list', ['meetingId' => $this->meetingId]);
    }

}