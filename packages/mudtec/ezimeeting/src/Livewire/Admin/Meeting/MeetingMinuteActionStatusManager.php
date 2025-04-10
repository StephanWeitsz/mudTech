<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\MeetingMinuteActionStatus;

class MeetingMinuteActionStatusManager extends Component
{  
    public $description;
    public $text;
    public $color = '#000000';
    public $order = 1;
    public $is_active = true;
    
    public $statuses;
    public $statusId;

    public $page_heading = 'Meeting Minute Action Status';
    public $page_sub_heading = 'Manage Meeting Minute Action Statuses';

    public function render()
    {
        $this->statuses = MeetingMinuteActionStatus::orderBy('order')->get();
        return view('ezimeeting::livewire.admin.meeting.meeting-minute-action-status-manager');
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

        MeetingMinuteActionStatus::create([
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
        $status = MeetingMinuteActionStatus::findOrFail($id);

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

        $status = MeetingMinuteActionStatus::findOrFail($this->statusId);
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
        MeetingMinuteActionStatus::findOrFail($id)->delete();
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
        $status = MeetingMinuteActionStatus::findOrFail($id);
        $status->is_active = !$status->is_active;
        $status->save();
    }
}