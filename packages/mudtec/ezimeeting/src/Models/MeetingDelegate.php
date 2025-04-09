<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDelegate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id',
        'delegate_name',
        'delegate_email',
        'delegate_role_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'delegate_email', 'email');
    }
    
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_meeting_delegate')
            ->withTimestamps();
    }

    public function role()
    {
        return $this->belongsTo(DelegateRole::class, 'delegate_role_id');
    }

    public function minutes()
    {
        return $this->belongsToMany(MeetingMinute::class, 'meeting_attendees')
            ->withPivot('meeting_attendee_status_id')
            ->withTimestamps();
    }

    public function meetingAction()
    {
        return $this->hasMany(Meeting::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function actions()
    {
        return $this->belongsToMany(MeetingMinuteAction::class, 'action_responsibilities')
            ->withTimestamps();
    }
}
