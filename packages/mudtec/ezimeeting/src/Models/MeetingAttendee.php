<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingAttendee extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'meeting_attendees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minute_id',
        'meeting_delegate_id',
        'meeting_attendee_status_id',
    ];

    // Define a belongsTo relationship with MeetingMinute
    public function minute()
    {
        return $this->belongsTo(MeetingMinute::class, 'minute_id');
    }

    // Define a belongsTo relationship with MeetingDelegate
    public function delegate()
    {
        return $this->belongsTo(MeetingDelegate::class, 'meeting_delegate_id');
    }

    // Define a belongsTo relationship with MeetingAttendeeStatus
    public function status()
    {
        return $this->belongsTo(MeetingAttendeeStatus::class, 'meeting_attendee_status_id');
    }
    
    // Define a scope to filter active attendees
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by the 'order' column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
