<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Mudtec\Ezimeeting\Models\Role;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingLocation;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingDelegate;
use Mudtec\Ezimeeting\Models\DelegateRole;

class NewMeetingDelegates extends Component
{
    public $meetingId;
    public $corpid;

    public $search;

    public $user;
    public $avaUsers;
    public $assUsers;

    public $corporation;

    public $meeting;
    public $description;
    public $department;
    public $scheduled_at;
    public $duration;
    public $location;
    public $interval;
    public $meeting_url;

    public $assignedUsers = [];
    public $removeUsers = [];

    public $displayAdhocUser = false;
    public $adhocUserName;
    public $adhocUserEmail;
        
    public $page_heading = 'Meeting Delegates';
    public $page_sub_heading = 'Add delegates';

    public function mount($meetingId, $corpId) 
    {           
        $this->meetingId = $meetingId;
        $this->corpid = $corpId;
        
        $this->user = User::find(auth()->id());
        $this->avaUsers = User::whereHas('corporations', function ($query) {          
            $query->where('corporation_id', $this->corpid);
        })
        ->whereDoesntHave('meetingDelegates', function ($query) {
            $query->where('meeting_id', $this->meetingId)
                  ->where('is_active', true);
        })
        ->where(function ($query) {
            $query->where('name', 'ilike', "%{$this->search}%")
                  ->orWhere('email', 'ilike', "%{$this->search}%");
        })
        ->get();
        
        $this->meeting = Meeting::find($this->meetingId);
        $this->description = $this->meeting->description;
        $this->department = Department::where('id', $this->meeting->department->id)->pluck('name')->first();
        $this->scheduled_at = $this->meeting->scheduled_at;
        $this->duration = $this->meeting->duration;

        $this->location = MeetingLocation::where('id', $this->meeting->meeting_location_id)->pluck('description')->first();
        $this->interval = MeetingInterval::where('id', $this->meeting->meeting_interval_id)->pluck('description')->first();

        $this->meeting_url = $this->meeting->external_url;

        $this->corporation = Corporation::where('id', $corpId)->first();
      
        $this->assUsers = MeetingDelegate::where('meeting_id', $this->meetingId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('delegate_name', 'ilike', "%{$this->search}%")
                      ->orWhere('delegate_email', 'ilike', "%{$this->search}%");
            })
            ->get();
    }

    public function saveAssignments()
    {
        $this->validate([
            'assignedUsers' => 'required|array|min:1',
            'assignedUsers.*' => 'required|integer',
        ]);

        $delegateRole = DelegateRole::where('description', 'Attendee')->pluck('id')->first();                         
        foreach ($this->assignedUsers as $delegate) {
            
            $existingDelegate = MeetingDelegate::where('meeting_id', $this->meetingId)
                ->where('delegate_email', User::find($delegate)->email)
                ->first();

            if ($existingDelegate) {
                try {
                    $existingDelegate->update([
                        'is_active' => true,
                    ]);
                    session()->flash('message', 'Meeting delegates saved successfully.');
                } //try {
                catch (\Exception $e) {
                    session()->flash('error', 'Error saving meeting delegates.');
                } //catch (\Exception $e) {
            } //if ($existingDelegate) { 
            else {
                try {
                    MeetingDelegate::create([
                        'meeting_id' => $this->meetingId,
                        'delegate_name' => User::find($delegate)->name,
                        'delegate_email' => User::find($delegate)->email,
                        'delegate_role_id' => $delegateRole,
                        'is_active' => true,
                    ]);
                    session()->flash('message', 'Meeting delegates saved successfully.');
                } //try {
                catch (\Exception $e) {
                    Log::error('Meeting delegate not created', ['error' => $e->getMessage()]);
                    session()->flash('error', 'Error saving meeting delegates.');
                } //catch (\Exception $e) {    
            } //else
        } //foreach ($this->assUsers as $userId) {
       

        $this->avaUsers = User::whereHas('corporations', function ($query) {
            $query->where('corporation_id', $this->corpid);
        })->whereDoesntHave('meetingDelegates', function ($query) {
            $query->where('meeting_id', $this->meetingId)
                  ->where('is_active', true);
        })->get();

        $this->assUsers = MeetingDelegate::where('meeting_id', $this->meetingId)
            ->where('is_active', true)
            ->get();

        Log::info('Assigned Users:', ['assUsers' => $this->assignedUsers]);

        $this->assignedUsers = []; // Reset the assignedUsers array
        $this->removeUsers = [];
        $this->search = "";
    }

    public function removeAssignments() 
    {
        $this->validate([
            'removeUsers' => 'required|array|min:1',
            'removeUsers.*' => 'required|integer',
        ]);

        foreach ($this->removeUsers as $removeUser) {
            try {
                $removeEmail = MeetingDelegate::find($removeUser)->delegate_email;
                $existingDelegate = MeetingDelegate::where('meeting_id', $this->meetingId)
                    ->where('delegate_email', $removeEmail)
                    ->where('is_active', true)
                    ->first();
     
                if ($existingDelegate) {
                    try {
                        $existingDelegate->update([
                            'is_active' => false,
                        ]);
                        session()->flash('message', 'Meeting delegates removed successfully.');
                    }
                    catch (\Exception $e) {
                        session()->flash('error', 'Error removing meeting delegates.');
                    }    
                } 
                else {
                    //session()->flash('error', 'Delegate not found. ' . $removeUser);
                }
            } //try {
            catch (\Exception $e) {
                session()->flash('error', 'Error removing meeting delegates.');
            } //catch (\Exception $e) {
        } //foreach ($this->assUsers as $userId) {

        $this->avaUsers = User::whereHas('corporations', function ($query) {
            $query->where('corporation_id', $this->corpid);
        })->whereDoesntHave('meetingDelegates', function ($query) {
            $query->where('meeting_id', $this->meetingId)
                  ->where('is_active', true);
        })->get();

        $this->assUsers = MeetingDelegate::where('meeting_id', $this->meetingId)
                ->where('is_active', true)
                ->get();

        $this->assignedUsers = []; // Reset the assignedUsers array
        $this->removeUsers = []; // Reset the removeUsers array
        $this->search = "";
    }

    public function showAdhocUser()
    {
        $this->displayAdhocUser = true;
    }

    public function saveAdhocUser() {

        $this->validate([
            'adhocUserName' => 'required|string',
            'adhocUserEmail' => 'required|email',
        ]);

        $userRole = Role::where('description', 'User')->first();
        User::create([
            'name' => $this->adhocUserName,
            'email' => $this->adhocUserEmail,
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(16)),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ])->assignRole($userRole);

        $adhocUser = User::where('email', $this->adhocUserEmail)->first();
        $this->corporation->users()->attach($adhocUser->id);

        $existingDelegate = MeetingDelegate::where('meeting_id', $this->meetingId)
            ->where('delegate_email', $this->adhocUserEmail)
            ->first();

        if ($existingDelegate) {
            try {
                $existingDelegate->update([
                    'is_active' => true,
                ]);
                session()->flash('message', 'Adhoc user added and activated successfully.');
            }
            catch (\Exception $e) {
                session()->flash('error', 'Error saving meeting adhoc delegate.');
            }    
        } //if ($existingDelegate) {
        else {
            try {
                MeetingDelegate::create([
                'meeting_id' => $this->meetingId,
                'delegate_name' => $this->adhocUserName,
                'delegate_email' => $this->adhocUserEmail,
                'delegate_role_id' => DelegateRole::where('description', 'Attendee')->pluck('id')->first(),
                'is_active' => true,
                ]);
                session()->flash('message', 'Adhoc user added as a new delegate successfully.');
            } catch (\Exception $e) {
                session()->flash('error', 'Error saving meeting adhoc delegate.');
            }
        } //else

        $this->avaUsers = User::whereHas('corporations', function ($query) {
            $query->where('corporation_id', $this->corpid);
        })->whereDoesntHave('meetingDelegates', function ($query) {
            $query->where('meeting_id', $this->meetingId)
                  ->where('is_active', true);
        })->get();

        $this->assUsers = MeetingDelegate::where('meeting_id', $this->meetingId)
                ->where('is_active', true)
                ->get();

        $this->assignedUsers = []; // Reset the assignedUsers array
        $this->removeUsers = [];
        $this->search = "";
        $this->displayAdhocUser = false;
    } 

    public function hideAdhocUser()
    {
        $this->displayAdhocUser = false;
    }

    public function render()
    {
        //unset($this->removeUsers);
        return view('ezimeeting::livewire.meeting.new-meeting-delegates');
    }
}