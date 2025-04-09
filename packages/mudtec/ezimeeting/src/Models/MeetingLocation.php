<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingLocation extends Model
{
    use HasFactory;

    // Define the attributes that are mass assignable
    protected $fillable = [
        'description',
        'text',
        'corporation_id',
        'is_active',
    ];

    // Define the attributes that should be cast to native types
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that the manager belongs to.
     * This method defines a belongsTo relationship with Meeting model.
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Get the corporation that the location belongs to.
     * This method defines a belongsTo relationship with Meeting model.
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
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