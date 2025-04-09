<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Departments;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Mudtec\Ezimeeting\Models\Department;

class DepartmentEdit extends Component
{
    use WithFileUploads;

    public $corporation_id;
    public $department;
    public $name;
    public $description;
    public $text;

    public $page_heading = 'Departments';
    public $page_sub_heading = 'Edit Department';

    public function mount($corporation, Department $department)
    {
        $this->corporation_id = $corporation;
        $this->department = $department;
        $this->name = $department->name;
        $this->description = $department->description;
        $this->text = $department->text;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);


        $dep = $this->department->update([
            'name' => $this->name,
            'description' => $this->description,
            'text' => $this->text,
            'corporation_id' => $this->corporation_id,
        ]);

        //$this->reset(['name', 'description','text', 'website', 'logo']);

        session()->flash('success', 'Corporate Updated!');
        $this->dispatch('Corporate Updated', $dep);
        return;
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.departments.department-edit');
    }
}