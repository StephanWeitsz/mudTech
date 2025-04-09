<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

use Mudtec\Ezimeeting\Models\MeetingDelegate;

/**
 * The DelegateRole model.
 *
 * @property int $id
 * @property string $description
 * @property string $text
 * @property-read \Illuminate\Database\Eloquent\Collection|MeetingDelegate[] $meetingDelegates
 */
class DelegateRole extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delegate_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'text',
        'is_active',
    ];
    
    // Define the attributes that should be cast to native types
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the meeting delegates associated with this role.
     */
    public function MeetingDelegates():hasMany
    {
        return $this->hasMany(MeetingDelegate::class);
    }
}