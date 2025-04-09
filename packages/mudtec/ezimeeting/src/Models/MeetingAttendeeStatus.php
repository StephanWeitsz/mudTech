<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

/**
 * The MeetingAttendeeStatus model.
 * 
 * @property int $id
 * @property string $description
 * @property string $text
 * @property string $color
 * @property int $order
 * @property bool $is_active
 */
class MeetingAttendeeStatus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meeting_attendee_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'text',
        'color',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function attendees():hasMany
    {
        return $this->hasMany(MeetingAttendee::class);
    }

    /**
     * Get the meeting attendees with this status.
     */
    public function meetingAttendees():hasMany
    {
        return $this->hasMany(MeetingAttendee::class);
    }

    // Define a scope to filter active intervals
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
