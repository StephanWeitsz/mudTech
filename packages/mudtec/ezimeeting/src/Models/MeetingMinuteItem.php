<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mudtec\Ezimeeting\Models\MeetingMinuteNote;

class MeetingMinuteItem extends Model
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
        'date_closed',
    ];

    // Define a belongsToMany relationship with MeetingMinute model
    public function meetingMinute() {
        return $this->belongsToMany(MeetingMinute::class, 'meeting_minute_meeting_minute_item', 'meeting_minute_id', 'meeting_minute_item_id') ->withTimestamps();
    }

    public function meetingMinuteNotes() {
        return $this->hasMany(MeetingMinuteNote::class, 'meeting_minute_item_id');
    }
}