<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User as BaseUser;

//use Illuminate\Database\Eloquent\Relations\hasMany;
//use Illuminate\Database\Eloquent\Relations\BelongsToMany;

//use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends BaseUser
{
    use HasFactory;
    
    protected $table = 'users';
    
    // Define a belongsToMany relationship with Role model   
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function assignRole($role)
    {
        // You can add logic here to handle the assignment of a role
        $this->roles()->attach($role);  // Attaches the role to the pivot table
    }

    public function hasRole($roleName)
    {
        return $this->roles()
                        ->whereRaw('LOWER(description) = ?', [strtolower($roleName)])
                        ->exists();
    }

    public function corporations()
    {
        return $this->belongsToMany(Corporation::class, 'corporation_user', 'user_id', 'corporation_id')->withTimestamps();
    }

    // Define a hasMany relationship with LoginLog model
    public function loginlog()
    {
        return $this->hasMany(LoginLog::class);
    }

    public function meetingDelegates()
    {
        return $this->hasMany(MeetingDelegate::class, 'delegate_email', 'email');
        
    }

}