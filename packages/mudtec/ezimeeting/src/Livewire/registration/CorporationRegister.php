<?php

namespace Mudtec\Ezimeeting\Livewire\Registration;

use Livewire\Component;

use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Role;

use Mudtec\Ezimeeting\Mail\JoinRequestMail;

class CorporationRegister extends Component
{
    //public $corporations;

    public $viewModal = false;
    public $selectedCorporation;

    public $passcode;

    public $page_heading = 'Corporations';
    public $page_sub_heading = 'Register';

    public function mount()
    {
        //$this->corporations = Corporation::all();
    }

    public function showCorporation($corporationId)
    {
        $this->selectedCorporation = Corporation::find($corporationId);
        $this->viewModal = true; 
    }

    public function closeModal()
    {
        $this->viewModal = false;
    }

    public function usePasscode() {
        $passCode = $this->passcode;

        if($this->selectedCorporation->secret) {
            if($passCode == $this->selectedCorporation->secret) {
                $this->selectedCorporation->users()->attach(auth()->user()->id);
                session()->flash('success', 'You have been linked to the corporation successfully.');
            }
            else {
                Log::warning('Invalid passcode for corporation: '. $this->selectedCorporation->name);
                session()->flash('error', 'Invalid passcode provided.');
            }
        }
        else {
            if($passCode == systemPassCode()) {
                $this->selectedCorporation->users()->attach(auth()->user()->id);
                $user = User::find(auth()->user()->id);     
                $attendeeRole = Role::where('description', 'Attendee')->first();
                if($attendeeRole) {
                    $user->assignRole($attendeeRole);
                    session()->flash('success', 'Granted Attendee Access.');
                }
                session()->flash('success', 'You have been linked to the corporation successfully.');
            }
            else {
                Log::warning('Invalid passcode for corporation: '. $this->selectedCorporation->name);
                session()->flash('error', 'Invalid passcode provided.');
            }
        }
    }

    public function sendJoinRequest() {

        $user = auth()->user();
        $corporation = $this->selectedCorporation;

        $corpAdminEmails = User::whereHas('roles', function ($query) {
            $query->where('description', 'corpAdmin');
        })->pluck('email')->toArray();

        // Send email to corporation email and CC admin and super admin
        try {
            Mail::to($corporation->email)
            ->cc($corpAdminEmails)
            ->send(new JoinRequestMail($user, $corporation));
            Log::error('Join request sent successfully. (' . $corporation->email .')');
            session()->flash('success', 'Join request sent successfully. (' . $corporation->email .')');
        } catch (\Exception $e) {
            Log::error('Failed to send join request email: ' . $e->getMessage());
            session()->flash('error', 'Failed to send join request. Please try again later.');
        }
    }

    public function render()
    {
        return view('ezimeeting::livewire.registration.corporation-register', [
            'corporations' => Corporation::all(),
        ]);
    }

}