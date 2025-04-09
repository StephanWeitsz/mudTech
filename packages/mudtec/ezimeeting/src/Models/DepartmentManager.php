<?php

namespace Mudtec\Ezimeeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DepartmentManager Model
 *
 * @property int $id
 * @property string $display_name
 * @property string $email
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Department $department
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentManager query()
 */
class DepartmentManager extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'department_managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'department_id',
    ];

    /**
     * Get the User that will act as manager for this department.
     */

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that the manager belongs to.
     */
    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
       
}