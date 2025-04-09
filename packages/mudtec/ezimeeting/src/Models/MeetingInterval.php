<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingInterval extends Model
{
    use HasFactory;

    // Define the attributes that are mass assignable
    protected $fillable = [
        'description',
        'text',
        'order',
        'formula',
        'is_active',
    ];

    // Define the attributes that should be cast to native types
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the department that the manager belongs to.
     * This method defines a belongsTo relationship with Meeting model.
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
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