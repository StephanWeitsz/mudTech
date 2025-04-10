<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Users;

use Livewire\Component;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;

class UserRoles extends Component
{
    public $users;
    public $selectedUser;
    public $selectedRoles = [];

    public function mount()
    {
        $this->users = User::all();
    }

    public function assignRoles()
    {
        $user = User::find($this->selectedUser);
        $user->syncRoles($this->selectedRoles);
    }

    public function render()
    {
        return view('livewire.admin.user-roles');
    }
}