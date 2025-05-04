<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
    ];

    public function descriptors(): MorphMany
    {
        return $this->morphMany(MeetingMinuteDescriptor::class, 'descriptor');
    }
    

}
