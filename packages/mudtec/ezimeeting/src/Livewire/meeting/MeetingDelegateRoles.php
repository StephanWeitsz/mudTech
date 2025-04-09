<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;


use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\DelegateRole;
use Mudtec\Ezimeeting\Models\MeetingDelegate;

class MeetingDelegateRoles extends Component
{
 
    public $assignedRoles = [];
    public $delegateRoles;
    public $delegates;
    public $meetingId;

    public $search;
    public $page_heading = 'Meeting Delegate Roles';
    public $page_sub_heading = 'Manage Delegate Roles';

    public function mount($meetingId) 
    {
        $this->delegateRoles =  DelegateRole::all();
        $this->meetingId = $meetingId;
        $this->initializeAssignedRoles();
    }

    public function initializeAssignedRoles()
    {
        $this->delegates = MeetingDelegate::where('meeting_id', $this->meetingId)
            ->orderBy('delegate_name')
            ->get();
            
        foreach ($this->delegates as $delegate) {
            $this->assignedRoles[$delegate->id] = $delegate->delegate_role_id;
        }
    }

    public function setRole($delegateId, $roleId)
    {
        $delegate = MeetingDelegate::find($delegateId);
        if ($delegate) {
            $delegate->delegate_role_id = $roleId;
            $delegate->save();
            //$this->assignedRoles[$delegateId] = $roleId;
        } //if ($delegate) {
        else {
            session()->flash('error', 'Delegate not found.');
        } //else
    }
   
    public function render()
    {
        $this->delegates = MeetingDelegate::where('meeting_id', $this->meetingId)
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('delegate_name', 'ilike', '%' . $this->search . '%')
                          ->orWhere('delegate_email', 'ilike', '%' . $this->search . '%');
                });
            })
            ->orderBy('delegate_name')
            ->get();

        return view('ezimeeting::livewire.meeting.meeting-delegate-roles');
    }

}