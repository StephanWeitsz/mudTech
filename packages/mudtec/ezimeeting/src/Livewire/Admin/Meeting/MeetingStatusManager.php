<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Illuminate\Validation\Rule;

class MeetingStatusManager extends Component
{
    public $description;
    public $text;
    public $color = '#000000';
    public $order = 1;
    public $is_active = true;
    public $statusId;
    public $statuses;

    public $page_heading = 'Meeting Statuses';
    public $page_sub_heading = 'Manage Meeting Status';

    public function render()
    {
        $this->statuses = MeetingStatus::orderBy('order')->get();
        return view('ezimeeting::livewire.admin.meeting.meeting-status-manager');
    }

    public function createStatus()
    {
        $this->validate([
            'description' => 'required|string|unique:meeting_statuses,description',
            'text' => 'nullable|string',
            'color' => 'required|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        MeetingStatus::create([
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
        $status = MeetingStatus::findOrFail($id);

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
            'description' => [
                'required', 'string',
                Rule::unique('meeting_statuses', 'description')->ignore($this->statusId),
            ],
            'text' => 'nullable|string',
            'color' => 'required|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $status = MeetingStatus::findOrFail($this->statusId);
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
        MeetingStatus::findOrFail($id)->delete();
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
        $status = MeetingStatus::findOrFail($id);
        $status->is_active = !$status->is_active;
        $status->save();
    }
}
