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
        'meeting_minute_action_status_id',
    ];

    public function status()
    {
        return $this->belongsTo(MeetingMinuteActionStatus::class);
    }

    public function delegates()
    {
        return $this->belongsToMany(MeetingDelegate::class, 'action_responsibilities')
            ->withTimestamps();
    }

    public function descriptors()
    {
        return $this->morphMany(MeetingMinuteDescriptor::class, 'descriptor');
    }

}
