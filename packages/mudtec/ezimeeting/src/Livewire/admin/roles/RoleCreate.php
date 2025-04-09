<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Storage;

use Mudtec\Ezimeeting\Models\Role;

class RoleCreate extends Component
{
    public $description;
    public $text;

    public $page_heading = 'Role Create';
    public $page_sub_heading = 'Adding a new role';

    public function store()
    {
        $this->validate([
            'description' => 'required',
            'text' => 'required',
        ]);
   
        $role = Role::create([
            'description' => $this->description,
            'text' => $this->text,
        ]);

        session()->flash('success', 'Role Created!');
        $this->dispatch('Role Created', $role);
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.roles.role-create');
    }
}