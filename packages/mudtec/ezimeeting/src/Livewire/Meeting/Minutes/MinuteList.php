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

class MinuteList extends Component
{
    public $minuteId;

    public $meetingId;
    public $meetingStatus;
    public $meetingMinutes;

    public $page_heading = 'Meeting List (Latest)';

    public function mount($meetingId, $minuteId) 
    {
        $status = MeetingStatus::findOrFail(Meeting::findOrFail($meetingId)->meeting_status_id);
        $this->meetingStatus = $status->description;
        
        Log::info('mount meeting minute');
        if(isset($minuteId) and !empty($minuteId)) {
            $this->minuteId = $minuteId;

            $this->meetingMinutes = MeetingMinute::where('meeting_id', $meetingId)
                                                    ->where('id', '=', $minuteId)
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

    //MeetingMinuteCreate
    public function MeetingMinuteCreate($meetingId) {
        return redirect()->route('MinuteDetail', ['meetingId' => $meetingId, 'minuteId' => 0]);
    }

    //MeetingMinuteDetail
    public function MeetingMinuteDetail($meetingId,$minuteId) {
        return redirect()->route('MinuteDetail', ['meetingId' => $meetingId, 'minuteId' => $minuteId]);
    }

    public function listMeetingMinutes($meetingId) {

        Log::info('list meeting minute');
        //dd('list meeting minute');
        return redirect()->route('MinuteList', ['meetingId' => $meetingId]);
    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.minutes.minute-list', ['meetingId' => $this->meetingId]);
    }

}