<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinute extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'meeting_minutes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id',
        'meeting_date',
        'meeting_transcript',
        'meeting_state',
    ];
  
    // Define a hasMany relationship with Meeting model
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function items()
    {
        return $this->belongsToMany(MeetingMinuteItem::class, 'meeting_minute_meeting_minute_item', 'meeting_minute_id', 'meeting_minute_item_id');
    }

    public function descriptors()
    {
        return $this->hasMany(MeetingMinuteDescriptor::class);
    }

    // Define a belongsToMany relationship with MeetingDelegate model
    public function attendees()
    {
        return $this->belongsToMany(MeetingDelegate::class, 'meeting_attendees')
            ->withPivot('meeting_attendee_status_id')
            ->withTimestamps();
    }

}