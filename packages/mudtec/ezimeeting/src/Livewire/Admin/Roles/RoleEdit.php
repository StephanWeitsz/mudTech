<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Storage;

use Mudtec\Ezimeeting\Models\Role;

class RoleEdit extends Component
{
    public $role;
    public $description;
    public $text;

    public $page_heading = 'Role';
    public $page_sub_heading = 'Editing a role';

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->description = $role->description;
        $this->text = $role->text;
    }

    public function update()
    {
        $this->validate([
            'description' => 'required',
            'text' => 'required',
        ]);
   
        $result = $this->role->update([
            'description' => $this->description,
            'text' => $this->text,
        ]);

        session()->flash('success', 'Role Updated!');
        $this->dispatch('Role Updated', $result);
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.roles.role-edit');
    }
}