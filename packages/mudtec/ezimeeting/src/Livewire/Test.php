<?php

namespace Mudtec\Ezimeeting\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Test extends Component
{
    use WithPagination;

    #[Rule('required|min:2|max:50')]
    public $name;

    #[Rule('required|email|unique:users')]
    public $email;

    #[Rule('required|min:7')]
    public $password;

    public function createNewUser() {

        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        $this->reset(['name','email','password']);

        request()->session()->flash('success', 'User Created Successfully!');

    }

    public function render()
    {
        $title = 'User Creation';
        $users = User::paginate(4);
        return view('ezimeeting::livewire.test', [
            'title' => $title,
            'users' => $users
        ]);
    }
}