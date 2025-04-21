<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mudtec\Ezimeeting\Models\MeetingMinuteDescriptor;

class MeetingMinuteDescriptor extends Model
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
        'descriptor_type',
        'descriptor_id',
        'date_logged',
        'date_due',
        'date_revised',
        'date_closed',
    ];

    public function minute()
    {
        return $this->belongsTo(MeetingMinute::class);
    }

    public function item()
    {
        return $this->belongsTo(MeetingMinuteItem::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(MeetingMinuteDescriptorFeedback::class);
    }

    public function descriptor()
    {
        return $this->morphTo(__FUNCTION__, 'descriptor_type', 'descriptor_id');
    }

    public function parent()
    {
        return $this->belongsTo(MeetingMinuteDescriptor::class, 'parent_descriptor_id');
    }

    public function children()
    {
        return $this->hasMany(MeetingMinuteDescriptor::class, 'parent_descriptor_id');
    }
    
}