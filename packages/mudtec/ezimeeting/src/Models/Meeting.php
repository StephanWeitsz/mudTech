<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Meeting model.
 * 
 * @property int $id
 * @property string $description
 * @property string $text
 * @property string $purpose
 * @property int $department_id
 * @property \Illuminate\Support\Carbon $schedules_at
 * @property int $duration
 * @property int $meeting_interval_id
 * @property int $meeting_status_id
 * @property int $meeting_location_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Department $department
 * @property-read MeetingInterval $meetingInterval
 * @property-read MeetingStatus $meetingStatus
 * @property-read MeetingLocation $meetingLocation
 */
class Meeting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meetings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'text',
        'purpose',
        'department_id',
        'scheduled_at',
        'duration',
        'meeting_interval_id',
        'meeting_status_id',
        'meeting_location_id',
        'external_url',
        'created_by_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * Get the department that the meeting belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function delegates()
    {
        return $this->belongsToMany(MeetingDelegate::class, 'meeting_meeting_delegate')
            ->withTimestamps();
    }

    /**
     * Get the meeting interval associated with the meeting.
     */
    public function meetingInterval(): BelongsTo
    {
        return $this->belongsTo(MeetingInterval::class);
    }

    /**
     * Get the meeting status associated with the meeting.
     */
    public function meetingStatus(): BelongsTo
    {
        return $this->belongsTo(MeetingStatus::class);
    }

    /**
     * Get the meeting location associated with the meeting.
     */
    public function meetingLocation(): BelongsTo
    {
        return $this->belongsTo(MeetingLocation::class);
    }

}