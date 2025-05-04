<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionResponsibility extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_responsibilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_minute_action_id',
        'meeting_delegate_id',
    ];

    /**
     * Relationship to the MeetingMinuteAction model.
     */
    public function action()
    {
        return $this->belongsTo(MeetingMinuteAction::class, 'meeting_minute_action_id');
    }

    /**
     * Relationship to the MeetingDelegate model.
     */
    public function delegate()
    {
        return $this->belongsTo(MeetingDelegate::class, 'meeting_delegate_id');
    }
}