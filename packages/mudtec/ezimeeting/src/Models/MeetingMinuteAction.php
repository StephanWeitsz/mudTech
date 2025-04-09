<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinuteAction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'text',
        'date_logged',
        'date_due',
        'date_due_revised',
        'date_closed',
        'meeting_minute_note_id',
        'meeting_minute_action_status_id',
    ];

    public function meetingMinuteNote()
    {
        return $this->belongsTo(MeetingMinuteNote::class);
    }

    public function meetingMinuteActionFeedbacks()
    {
        return $this->hasMany(MeetingMinuteActionfeedback::class);
    }

    public function meetingMinuteActionStatus()
    {
        return $this->belongsTo(MeetingMinuteActionStatus::class);
    }

    public function delegates()
    {
        return $this->belongsToMany(MeetingDelegate::class, 'action_responsibilities')
            ->withTimestamps();
    }
}
