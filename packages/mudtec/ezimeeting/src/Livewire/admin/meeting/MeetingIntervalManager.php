<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Illuminate\Validation\Rule;

class MeetingIntervalManager extends Component
{
    public $description;
    public $text;
    public $order = 1;
    public $formula;
    public $is_active = true;
    public $intervalId;
    public $intervals;

    public $page_heading = 'Meeting Interval';
    public $page_sub_heading = 'Manage Meeting Interval';

    public function render()
    {
        $this->intervals = MeetingInterval::orderBy('order')->get();
        return view('ezimeeting::livewire.admin.meeting.meeting-interval-manager');
    }

    public function createInterval()
    {
        $this->validate([
            'description' => 'required|string|unique:meeting_intervals,description',
            'text' => 'nullable|string',
            'order' => 'required|integer',
            'formula' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        MeetingInterval::create([
            'description' => $this->description,
            'text' => $this->text,
            'order' => $this->order,
            'formula' => $this->formula,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Interval Created');
        $this->resetForm();
    }

    public function editInterval($id)
    {
        $interval = MeetingInterval::findOrFail($id);

        // Set fields to update
        $this->intervalId = $interval->id;
        $this->description = $interval->description;
        $this->text = $interval->text;
        $this->order = $interval->order;
        $this->formula = $interval->formula;
        $this->is_active = $interval->is_active;
    }

    public function updateInterval()
    {
        if (!$this->intervalId) return;

        $this->validate([
            'description' => [
                'required', 'string',
                Rule::unique('meeting_intervals', 'description')->ignore($this->intervalId),
            ],
            'text' => 'nullable|string',
            'order' => 'required|integer',
            'formula' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $interval = MeetingInterval::findOrFail($this->intervalId);
        $interval->update([
            'description' => $this->description,
            'text' => $this->text,
            'order' => $this->order,
            'formula' => $this->formula,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Interval Updated');
        $this->resetForm();
    }

    public function deleteInterval($id)
    {
        MeetingInterval::findOrFail($id)->delete();
        session()->flash('success', 'Interval Deleted');
        $this->resetForm();
    }

    public function onCancelInterval()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->intervalId = null;
        $this->description = '';
        $this->text = '';
        $this->order = 1;
        $this->formula = '';
        $this->is_active = true;
    }

    public function toggleActive($id)
    {
        $interval = MeetingInterval::findOrFail($id);
        $interval->is_active = !$interval->is_active;
        $interval->save();
    }
}
