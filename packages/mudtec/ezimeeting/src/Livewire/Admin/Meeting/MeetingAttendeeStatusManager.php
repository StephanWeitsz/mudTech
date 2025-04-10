<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\MeetingAttendeeStatus;

class MeetingAttendeeStatusManager extends Component
{
    public $description;
    public $text;
    public $color = '#000000';
    public $order = 1;
    public $is_active = true;
    
    public $statuses;
    public $statusId;

    public $page_heading = 'Meeting Attendee Status';
    public $page_sub_heading = 'Manage Meeting Atendee Status';

    public function render()
    {
        $this->statuses = MeetingAttendeeStatus::orderBy('order')->get();
        return view('ezimeeting::livewire.admin.meeting.meeting-attendee-status-manager');
    }

    public function createStatus()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'text' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        MeetingAttendeeStatus::create([
            'description' => $this->description,
            'text' => $this->text,
            'color' => $this->color,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Status Created');
        $this->resetForm();
    }

    public function editStatus($id)
    {
        $status = MeetingAttendeeStatus::findOrFail($id);

        // Set fields to update
        $this->statusId = $status->id;
        $this->description = $status->description;
        $this->text = $status->text;
        $this->color = $status->color;
        $this->order = $status->order;
        $this->is_active = $status->is_active;
    }

    public function updateStatus()
    {
        if (!$this->statusId) return;

        $this->validate([
            'description' => 'required|string|max:255',
            'text' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $status = MeetingAttendeeStatus::findOrFail($this->statusId);
        $status->update([
            'description' => $this->description,
            'text' => $this->text,
            'color' => $this->color,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Status Updated');
        $this->resetForm();
    }

    public function deleteStatus($id)
    {
        MeetingAttendeeStatus::findOrFail($id)->delete();
        session()->flash('success', 'Status Deleted');
        $this->resetForm();
    }

    public function onCancelStatus()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->statusId = null;
        $this->description = '';
        $this->text = '';
        $this->color = '#000000';
        $this->order = 1;
        $this->is_active = true;
    }

    public function toggleActive($id)
    {
        $status = MeetingAttendeeStatus::findOrFail($id);
        $status->is_active = !$status->is_active;
        $status->save();
    }
}