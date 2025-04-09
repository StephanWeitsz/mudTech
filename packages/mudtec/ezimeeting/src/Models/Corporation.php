<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\User;

/**
 * The Corporation model.
 *
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $website
 * @property string $logo
 */
class Corporation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'corporations';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $fillable = [
        'name',
        'description',
        'text',
        'website',
        'email',
        'logo',
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
    
    public function setWebsiteAttribute($value)
    {
        $this->attributes['website'] = strip_tags($value);
    }
    
    /**
     * Get the department that the corporation belongs to.
     */
    


    public function departments():hasMany
    {
        return $this->hasMany(Department::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'corporation_user', 'corporation_id', 'user_id')->withTimestamps();
    }  
   
}