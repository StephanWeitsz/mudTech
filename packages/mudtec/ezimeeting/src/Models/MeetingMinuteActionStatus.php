<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinuteActionStatus extends Model
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

    /**
     * Get the meeting minute actions with this status.
     * This method defines a hasMany relationship with MeetingMinuteAction model.
     */
    public function meetingMinuteActions()
    {
        return $this->hasMany(MeetingMinuteAction::class);
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
