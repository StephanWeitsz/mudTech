<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\Corporation;

class MeetingLocationManager extends Component
{
    public $corporations;
    public $selectedCorporation;
    
    public $description;
    public $text;
    public $corporation_id;
    public $is_active = true;
    
    public $locations;
    public $locationId;

    public $page_heading = 'Meeting Interval';
    public $page_sub_heading = 'Manage Meeting Interval';

    public function mount()
    {
        $this->corporations = Corporation::all();
    }

    public function onCorporationSelected($id) {
        $this->selectedCorporation = $id;
        $this->corporation_id = $id;
        $this->locations = MeetingLocation::with('corporation')
                 ->where('corporation_id', $id)
                 ->get();
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.meeting.meeting-location-manager');
    }

    public function createLocation()
    {
        $this->corporation_id = $this->selectedCorporation;

        $this->validate([
            'description' => [
                'required', 'string',
                Rule::unique('meeting_locations', 'description')
                    ->where('corporation_id', $this->corporation_id),
            ],
            'text' => 'nullable|string',
            'corporation_id' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        MeetingLocation::create([
            'description' => $this->description,
            'text' => $this->text,
            'corporation_id' => $this->corporation_id,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Location Created');
        $this->resetForm();
    }

    public function editLocation($id)
    {
        $location = MeetingLocation::findOrFail($id);

        // Set fields to update
        $this->locationId = $location->id;
        $this->description = $location->description;
        $this->text = $location->text;
        $this->corporation_id = $location->corporation_id;
        $this->is_active = $location->is_active;
    }

    public function updateLocation()
    {
        if (!$this->locationId) return;

        //$this->corporation_id = $this->selectedCorporation;
        
        $this->validate([
            'description' => [
                'required', 'string',
                Rule::unique('meeting_locations', 'description')
                    ->where('corporation_id', $this->corporation_id)
                    ->ignore($this->locationId),
            ],
            'text' => 'nullable|string',
            'corporation_id' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $location = MeetingLocation::findOrFail($this->locationId);
        $location->update([
            'description' => $this->description,
            'text' => $this->text,
            'corporation_id' => $this->corporation_id,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Location Updated');
        $this->resetForm();
    }

    public function deleteLocation($id)
    {
        MeetingLocation::findOrFail($id)->delete();
        session()->flash('success', 'Location Deleted');
        $this->resetForm();
    }

    public function onCancelLocation()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->locationId = null;
        $this->description = '';
        $this->text = '';
        $this->corporation_id = $this->selectedCorporation;
        $this->is_active = true;
        $this->locations = MeetingLocation::with('corporation')
                 ->where('corporation_id', $this->selectedCorporation)
                 ->get();
    }

    public function toggleActive($id)
    {
        $location = MeetingLocation::findOrFail($id);
        $location->is_active = !$location->is_active;
        $location->save();
        $this->resetForm();
    }
}