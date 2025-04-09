<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;

class NewMeeting extends Component
{
    public $departments;
    public $intervals;
    public $locations;
    

    public $user;
    public $corpId;
    public $corporations;

    public $description;
    public $text;
    public $purpose;
    public $department_id;
    public $scheduled_at;
    public $duration;
    public $meeting_interval_id;
    public $meeting_status_id;
    public $meeting_location_id;
    public $external_url;
    public $created_by_user_id;

    public $page_heading = 'New Meeting Detail';
    public $page_sub_heading = 'Capture meeting details';

    public function mount() 
    {
        $this->intervals = MeetingInterval::all();

        $this->user = User::find(auth()->id());
        $userCorps = $this->user->corporations()->pluck('corporations.id');
        if ($userCorps->count() == 1) {
            $this->corpId = $userCorps->first();
            unset($this->corporations);
            $this->departments = Department::where('corporation_id', $this->corpId)->get();
            $this->locations = MeetingLocation::where('corporation_id', $this->corpId)->get();

        } else {
            $this->corpId = "";
            $this->corporations = $userCorps->toArray();

            //$this->departments = Department::whereIn('corporation_id', $this->corpId)->get();
            //$this->locations = MeetingLocation::whereIn('corporation_id', $this->corpId)->get();
            
        }
    }

    public function onCorporationSelected($id)
    {
        $this->corpId = $id;
        unset($this->corporations);
        $this->departments = Department::where('corporation_id', $this->corpId)->get();
        $this->locations = MeetingLocation::where('corporation_id', $this->corpId)->get();
    }

    public function store() 
    {
       
        $validatedData = $this->validate([
            'description' => ['required','string'],
            'text' => ['required','string'],
            'purpose' => ['required','string'],
            'department_id' => ['required', Rule::in($this->departments->pluck('id'))],
            'scheduled_at' => ['required', 'date'],
            'duration' => ['required','numeric'],
            'meeting_interval_id' => ['required', Rule::in($this->intervals->pluck('id'))],
            'meeting_location_id' => ['required', Rule::in($this->locations->pluck('id'))],
            'external_url' => ['nullable','url'],
        ]);

        $validatedData['meeting_status_id'] = 1;
        $validatedData['created_by_user_id'] = auth()->id();

        try {
            $meeting = Meeting::create($validatedData);
            $meetingNumber = $meeting->id;
            session()->flash('success', 'Meeting created successfully');
            return redirect()->route('newMeetingDelegates', ['meetingId' => $meetingNumber, 'corpId'=>$this->corpId]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: Problem creating meeting');
        }
    }

    public function render()
    {
        return view('ezimeeting::livewire.meeting.new-meeting');
    }
}