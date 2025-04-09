<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithFileUploads;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;

class UserEdit extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;

    public $profile_photo;
    public $profile_photo_path;    

    public $sub_heading = 'Account Detail';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_photo_path = $user->profile_photo_path;
    }

    public function render()
    {       
        return view('ezimeeting::livewire.admin.users.user-edit');
    }

    public function updatedProfilePhoto()
    {
        $this->profile_photo_path = $this->profile_photo->temporaryUrl();
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        if ($this->profile_photo) {
            // Delete the old image if it exists
            if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
            }

            // Store the new image and update the path
            $path = $this->profile_photo->store('profile-photos', 'public');
            $this->user->profile_photo_path = $path;
        } //if ($this->profile_photo) {

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_path' => $this->user->profile_photo_path,
        ]);

        session()->flash('success', 'User Updated!');
        $this->dispatch('User Updated', $this->user);
        return;
    }


}