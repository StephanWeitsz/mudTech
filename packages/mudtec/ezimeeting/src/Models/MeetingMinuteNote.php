<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinuteNote extends Model
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
        'meeting_minute_item_id',
    ];

    // Define a belongsTo relationship with MeetingMinuteActionStatus model
    

    // Define a belongsTo relationship with MeetingMinuteItem model
    public function meetingMinuteItem()
    {
        return $this->belongsTo(MeetingMinuteItem::class);
    }
    // Define a belongsTo relationship with MeetingMinuteAction model
    public function meetingMinuteActions()
    {
        return $this->hasMany(MeetingMinuteAction::class);
    }

    

}
