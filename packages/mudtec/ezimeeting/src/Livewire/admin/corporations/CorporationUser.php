<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Corporations;

use Livewire\Component;
use Livewire\WithPagination;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;

class CorporationUser extends Component
{
    use WithPagination;

    public $corporations;
    public $selectedCorporation;

    public $search = '';
    public $overRideUser = "";
    public $assignedUsers = [];

    public $page_heading = 'Corporation Users';
    public $page_sub_heading = 'Assign and Manage Corporation Users';
    
    public function mount()
    {
        $this->corporations = Corporation::all();
        //$this->users = collect();
    }

    public function onCorporationSelected($corporationId)
    {
        $this->selectedCorporation = $corporationId;   
        $corporation = Corporation::find($corporationId);
        $this->assignedUsers = $corporation ? $corporation->users->pluck('id')->toArray() : [];
        $corporation->users()->sync($this->assignedUsers);
        $this->overRideUser = "";
    }

    public function toggleUserAssignment($userId)
    {
        if (in_array($userId, $this->assignedUsers)) {
            $this->assignedUsers = array_diff($this->assignedUsers, [$userId]);
        } else {
            $this->assignedUsers[] = $userId;
        }
    }

    public function saveAssignments()
    {
        $corporation = Corporation::find($this->selectedCorporation);
        if ($corporation) {
            // Sync the assigned users
            $corporation->users()->sync($this->assignedUsers);
            //session()->flash('success', 'User assignments updated successfully!');
        } //if ($corporation) {
        else {
            session()->flash('error', 'Please select a corporation before saving.');
        } //else
    }

    public function overRideUsers() {
        $this->overRideUser = 1;        
    }

    public function render()
    {
        /*
        $users = User::whereDoesntHave('corporations', function ($query) {
            $query->where('corporations.id', '<>', $this->selectedCorporation);
        })
        ->where(function ($query) {
            $query->where('name', 'ilike', "%{$this->search}%")
                ->orWhere('email', 'ilike', "%{$this->search}%");
        })->paginate(20);
        */
        
        if($this->selectedCorporation) {

            if($this->overRideUser) {
                $availableUsers = User::where(function ($query) {
                    $query->where('name', 'ilike', "%{$this->search}%")
                    ->orWhere('email', 'ilike', "%{$this->search}%");
                })->paginate(20);
                if(!$availableUsers)
                    $availableUsers = collect();
            } //if($this->overRideUser) {
            else {
                $availableUsers = User::whereDoesntHave('corporations')
                ->where(function ($query) {
                    $query->where('name', 'ilike', "%{$this->search}%")
                        ->orWhere('email', 'ilike', "%{$this->search}%");
                })->paginate(20);
                if(!$availableUsers)
                    $availableUsers = collect();
            } //else

            $assignedUsers = User::whereHas('corporations', function ($query) {
                $query->where('corporations.id', $this->selectedCorporation);
            })
            ->where(function ($query) {
                $query->where('name', 'ilike', "%{$this->search}%")
                    ->orWhere('email', 'ilike', "%{$this->search}%");
            })->paginate(20);
            if(!$assignedUsers)
                $assignedUsers = collect();

        }
        else {
            $availableUsers = collect();
            $assignedUsers = collect();
        } //else

        return view('ezimeeting::livewire.admin.corporations.corporation-user', ['avaUsers' => $availableUsers, 'assUsers' => $assignedUsers]);
    }
}