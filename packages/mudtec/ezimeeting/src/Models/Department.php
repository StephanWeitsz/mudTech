<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\hasMany;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\DepartmentManager;
use Mudtec\Ezimeeting\Models\Meeting;

/**
 * The Department model.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $text
 * @property int $corporation_id
 * @property-read Corporation $corporation
 * @property-read DepartmentManager|null $manager
 * @property-read \Illuminate\Database\Eloquent\Collection|Meeting[] $meetings
 */
class Department extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'text',
        'corporation_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strip_tags($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strip_tags($value);
    }

    public function setTextAttribute($value)
    {
        $this->attributes['text'] = strip_tags($value);
    }
    
    /**
     * Get the corporation that the department belongs to.
     */
    public function corporation():BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * Get the manager that the department is allocated to.
     */
    public function manager():hasOne
    {
        return $this->hasOne(DepartmentManager::class);
    }
   
    /**
     * Get the meetings that the department has.
     */
    public function meetings():hasMany
    {
        return $this->hasMany(Meeting::class);
    }
}