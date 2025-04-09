<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Departments;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentCorporationsList extends Component
{
    use WithPagination;
    public $showEditForm = false;
    public $search;

    public $page_heading = 'Corporations';
    public $page_sub_heading = 'Select a corporation to view departments';

    public function render()
    {
        $corporations = Corporation::latest()
                            ->where('name', 'ilike', "%{$this->search}%")
                            ->paginate(20);

        return view('ezimeeting::livewire.admin.departments.department-corporations-list', ['corporations'=>$corporations]);
    } //public function render()
}
