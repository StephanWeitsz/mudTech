<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\DelegateRole;

class MeetingDelegateRoleManager extends Component
{
    public $description;
    public $text;
    
    public $roles;
    public $roleId;

    public $page_heading = 'Delegate Roles';
    public $page_sub_heading = 'Manage Delegate Roles';


    public function render()
    {
        $this->roles = DelegateRole::all();
        return view('ezimeeting::livewire.admin.meeting.meeting-delegate-role-manager');
    }

    public function createRole()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);

        DelegateRole::create([
            'description' => $this->description,
            'text' => $this->text,
        ]);

        session()->flash('success', 'Role Created');
        $this->resetForm();
    }

    public function editRole($id)
    {
        $role = DelegateRole::findOrFail($id);

        // Set fields to update
        $this->roleId = $role->id;
        $this->description = $role->description;
        $this->text = $role->text;
    }

    public function updateRole()
    {
        if (!$this->roleId) return;
        
        $this->validate([
            'description' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);

        $role = DelegateRole::findOrFail($this->roleId);
        $role->update([
            'description' => $this->description,
            'text' => $this->text,
        ]);

        session()->flash('success', 'Role Updated');
        $this->resetForm();
    }

    public function deleteRole($id)
    {
        DelegateRole::findOrFail($id)->delete();
        session()->flash('success', 'Role Deleted');
        $this->resetForm();
    }

    public function onCancelRole()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->roleId = null;
        $this->description = '';
        $this->text = '';
    }

    /*
    public function toggleActive($id)
    {
        $role = DelegateRole::findOrFail($id);
        $role->is_active = !$role->is_active;
        $role->save();
        $this->resetForm();
    }
    */
}