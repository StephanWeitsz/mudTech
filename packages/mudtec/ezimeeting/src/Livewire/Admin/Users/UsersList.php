<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Users;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;

class usersList extends Component
{
    use WithPagination;

    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 20;

    public $user;
    public $search;
   
    public $page_heading = 'Users';
    public $page_sub_heading = 'All Users';


    #[On('user-created')]
    public function updateList($user = null) {

    }

    public function placeholder() {
        return view('placeholder');
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
    
    public function corpDeleteUser($user) 
    {
        $this->user = User::find($user);
        $this->user->delete();
    }

    public function render()
    {
        $users = User::query()
        ->where('name', 'ilike', "%{$this->search}%")
        ->orwhere('email', 'ilike', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

        return view('ezimeeting::livewire.admin.users.users-list', compact('users'));
    }
}
