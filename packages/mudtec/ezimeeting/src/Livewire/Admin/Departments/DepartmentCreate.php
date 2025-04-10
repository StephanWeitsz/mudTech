<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Departments;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Storage;

use Mudtec\Ezimeeting\Models\Department;

class DepartmentCreate extends Component
{

    use WithFileUploads;

    public $name;
    public $description;
    public $text;
    public $corporation_id;

    public $page_heading = 'Departments';
    public $page_sub_heading = 'Add a department';

    public function mount($corporation) 
    {
        $this->corporation_id = $corporation;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        
        $dep = Department::create([
            'name' => $this->name,
            'description' => $this->description,
            'text' => $this->text,
            'corporation_id' => $this->corporation_id
        ]);

        //$this->reset(['name', 'description','text', 'website', 'logo']);

        //$this->emit('corporationsCreated');

        session()->flash('success', 'Corporate Created!');
        $this->dispatch('Department Created', $dep );

    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.departments.department-create');
    }


}