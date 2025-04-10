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

class MeetingMinutesView extends Component
{
    public $minutesId;

    public $meetingId;
    public $meetingStatus;
    public $meetingMinutes;

    public $page_heading = 'Meeting List';

    public function mount($meetingId, $minutesId) 
    {
        $status = MeetingStatus::findOrFail(Meeting::findOrFail($meetingId)->meeting_status_id);
        $this->meetingStatus = $status->description;
        
        Log::info('mount meeting minute');
        if(isset($minutesId) and !empty($minutesId)) {
            $this->minutesId = $minutesId;

            $this->meetingMinutes = MeetingMinute::where('meeting_id', $meetingId)
                                                    ->where('id', '=', $minutesId)
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        }
        else {
            if(isset($meetingId)) {
                $this->meetingId = $meetingId;
                $this->meetingMinutes = MeetingMinute::where('meeting_id', $meetingId)
                                                        ->orderBy('created_at', 'desc')
                                                        ->take(3)
                                                        ->get();
            }
            else {

            }
        }
    }

    public function MeetingMinuteDetails($meetingId) {
        return redirect()->route('MeetingMinuteDetails', ['meeting' => $meetingId]);
    }

    public function viewMeetingMinutes($meetingId,$minutesId) {
        return redirect()->route('viewMeetingMinutes', ['meeting' => $meetingId, 'minute' => $minutesId]);
    }

    public function listMeetingMinutes($meetingId) {
        Log::info('list meeting minute');
            
    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.meeting-minutes-view', ['meetingId' => $this->meetingId]);
    }

}