<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinuteDescriptorFeedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meeting_minute_descriptor_feedbacks';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_minute_descriptor_id',
        'text',
        'date_logged',
    ];
   
    public function descriptor()
    {
        return $this->belongsTo(MeetingMinuteDescriptor::class);
    }
}
