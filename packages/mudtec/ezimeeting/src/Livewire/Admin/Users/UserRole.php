<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Users;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Role;
use Livewire\Component;

class UserRole extends Component
{

    public $user;
    public $roles = [];
    public $selectedRoles = [];
    
    public $sub_heading = 'Rolles';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = Role::select('id', 'description')->get();
        $this->selectedRoles = $this->user->roles()->pluck('roles.id')->toArray();
    }

    public function toggleRole($roleId)
    {
        $this->user->roles()->toggle($roleId); // Laravel will attach/detach automatically
        $this->selectedRoles = $this->user->roles()->pluck('roles.id')->toArray();
    }

    public function render()
    {
        return view('ezimeeting::livewire.admin.users.user-role');
    }

}