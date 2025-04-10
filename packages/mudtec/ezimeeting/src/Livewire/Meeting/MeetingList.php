<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;

class MeetingList extends Component
{

    use WithPagination;

    //public $meetings;
    public $closeStatus;
    public $search;
    public $page_heading = 'Meeting List';
    public $page_sub_heading = 'Meetings you have access to';

    public function mount() 
    {
        $this->closeStatus = MeetingStatus::where('description', 'Closed')->first();
    }

    public function render()
    {
        $meetings = Meeting::when($this->search, function ($query) {
            $query->whereRaw('LOWER(description) LIKE ?', ['%' . mb_strtolower($this->search) . '%']);
            $query->orWhereRaw('LOWER(text)', 'LIKE ?', ['%' . mb_strtolower($this->search) . '%']);
            $query->orWhereRaw('LOWER(purpose)', 'LIKE ?', ['%' . mb_strtolower($this->search) . '%']);
            $query->orWhereRaw('LOWER(scheduled_at)', 'LIKE ?', ['%' . mb_strtolower($this->search) . '%']);
        })->paginate(10);

        return view('ezimeeting::livewire.meeting.meeting-list', ['meetings' => $meetings]);
    }

    public function view($id) 
    {
        return redirect()->route('meetingView', ['meeting' => $id]);
    }

    public function edit($id) 
    {
        return redirect()->route('meetingEdit', ['meeting' => $id]);
    }

    public function close($id) {
        try {
            $meeting = Meeting::find($id);
            $meeting->meeting_status_id = $this->closeStatus->id;
            $meeting->save();
            session()->flash('success', 'Meeting closed successfully.');
        }
        catch (\Exception $e) {
            Log::error('Error closing meeting: '. $e->getMessage());
            session()->flash('error', 'Error closing meeting. Please try again.');
        }
    }

    public function reopen($id) {
        try {
            $openStatus = MeetingStatus::where('description', 'reOpend')->first();

            $meeting = Meeting::find($id);
            $meeting->meeting_status_id = $openStatus->id;
            $meeting->save();
            session()->flash('success', 'Meeting re-Opend successfully.');
        }
        catch (\Exception $e) {
            Log::error('Error closing meeting: '. $e->getMessage());
            session()->flash('error', 'Error closing meeting. Please try again.');
        }    
    }
}