<?php

namespace Mudtec\Ezimeeting\Livewire\Admin\Departments;

use Livewire\Component;
use Livewire\WithPagination;

//use App\Models\User;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\DepartmentManager as DepMan;

class DepartmentManager extends Component
{
    use WithPagination;

    public $corporations;
    public $selectedCorporation;

    //public $departments;
    public $selectedDepartment;

    public $assignedUser = "";
    public $users;
    public $managers = "";

    public $page_heading = 'Department Manager';
    public $page_sub_heading = 'Assign and Manage Corporation / Department Manager';
    
    public function mount()
    {
        $this->corporations = Corporation::all();
        $this->users = collect();
    }

    public function onCorporationSelected($corporationId)
    {
        $this->selectedCorporation = $corporationId;
    }

 
    public function onManagerSelected($depId, $userId)
    {
        if (empty($depId) || empty($userId)) {
            session()->flash('error', 'Please select a valid department and manager.');
            return;
        }

        $departmentManager = DepMan::where('department_id', $depId)->first();
    
        if ($departmentManager) {
            // Update existing department manager

            $departmentManager->user_id = $userId;
            $departmentManager->save();
        } else {
            // Create new department manager
            $manager = User::findorfail($userId);

            $res = DepMan::create([
                'user_id' => $userId,
                'department_id' => $depId
            ]);
        }
    
        // Optionally, you can display a success message
        session()->flash('success', 'Department manager updated successfully!');
    }


 
    /*
    public function saveAssignments()
    {
        $corporation = Corporation::find($this->selectedCorporation);

        if ($corporation) {
            // Sync the assigned users
            $corporation->users()->sync($this->assignedUsers);
            session()->flash('message', 'User assignments updated successfully!');
        } else {
            session()->flash('error', 'Please select a corporation before saving.');
        }
    }
    */

    public function render()
    {
        if($this->selectedCorporation) {
            $corporationId = $this->selectedCorporation;
            
            $departments = Department::where('corporation_id', $corporationId )
                                ->orderBy('name')
                                ->paginate(20);
            
            $this->users = User::whereDoesntHave('corporations', 
                function ($query) use ($corporationId) {
                    $query->where('corporations.id', '=', $corporationId);
                })->get();

            $this->users = User::whereHas('corporations',
                function ($query) {
                    $query->where('corporations.id', $this->selectedCorporation);
                })->get();

            if ($departments) {
                $this->managers = DepMan::whereIn('department_id', $departments->pluck('id'))
                                        ->get()
                                        ->keyBy('department_id')
                                        ->toArray();
            } //if ($departments) {
            else {
                $this->managers = [];
            } //else
        } //if($this->selectedCorporation) { 
        else {
            $departments = collect();
        } //else

        return view('ezimeeting::livewire.admin.departments.department-manager',['departments'=>$departments]);
    }
}