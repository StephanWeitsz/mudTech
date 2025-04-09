<?php
namespace Mudtec\Ezimeeting\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Role;

class MailController extends Controller
{
    public function approve($userId, $corpId)
    {
        $corporation = Corporation::find($corpId);
        $user = User::find($userId);
        $corporation->users()->attach($user->id);    
        $attendeeRole = Role::where('description', 'Attendee')->first();
        if($attendeeRole) {
            $user->assignRole($attendeeRole);    
        }
    
        return redirect()->route('dashboard')->with('success', 'Request approved successfully.');
    }

    public function reject($id)
    {
        dd("Rejected");
        return redirect()->route('dashboard')->with('success', 'Request rejected successfully.');
    }
}