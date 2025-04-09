<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinuteActionFeedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'date_logged',
        'meeting_minute_action_id',
    ];
   
    public function meetingMinuteAction()
    {
        return $this->belongsTo(MeetingMinuteAction::class);
    }
}
