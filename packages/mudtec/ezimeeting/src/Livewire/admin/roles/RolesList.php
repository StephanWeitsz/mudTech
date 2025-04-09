<?php 

namespace Mudtec\Ezimeeting\Livewire\Admin\Roles;

use Mudtec\Ezimeeting\Models\Role;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class RolesList extends Component
{
    public $sortField = 'description';
    public $sortDirection = 'asc';
    public $perPage = 20;

    public $search;

    public $page_heading = 'Roles';
    public $page_sub_heading = 'All Roles';

    protected $listeners = ['deleteRole'];

    public function render()
    {
        $roles = Role::query()
            ->where('description', 'ilike', "%{$this->search}%")
            ->orwhere('text', 'ilike', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('ezimeeting::livewire.admin.roles.roles-list', compact('roles'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteRole($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return;
    }
}