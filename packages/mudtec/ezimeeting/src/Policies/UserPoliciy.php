<?php

namespace Mudtec\Ezimeeting\Policies;

use Mudtec\Ezimeeting\Models\User;

class UserPolicy
{
    public function isAdmin(User $user)
    {
        return $user->hasRole('admin');
    }

    public function isOrganizer(User $user)
    {
        return $user->hasRole('organizer');
    }

    public function isAttendee(User $user)
    {
        return $user->hasRole('attendee');
    }
}
