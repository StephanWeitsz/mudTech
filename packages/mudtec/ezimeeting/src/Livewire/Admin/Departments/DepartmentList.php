<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Departments;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentList extends Component
{
    use WithPagination;
        
    public $corporation;
    public $department;

    public $showEditForm = false;
    public $editingDepartment;
    public $search;
   
    public $page_heading = 'Departments';
    public $page_sub_heading = 'All Department';

    public function mount($corporation)
    {
        $this->corporation = $corporation;
        $corpName = Corporation::findOrfail($corporation)->name;
        $this->page_heading .= " For " . $corpName;
    }

    public function delete($corporation, $department) {
        try {
            Department::findOrfail($department)->delete();
        } catch(Exception $e) {
            request()->session()->flash('error', 'Delete Failed!');
            return;
        }
    }

    public function edit(Department $department)
    {
        $this->showEditForm = true;
        $this->editingDepartment = $department;
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.departments.department-list', [
            'departments' => Department::latest()
                ->where('name', 'ilike', "%{$this->search}%")
                ->where('corporation_id', '=', $this->corporation)
                ->paginate(20)
        ]);
    } //public function render()
}
