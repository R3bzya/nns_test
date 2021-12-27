<?php

namespace App\Models\Employee;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $name
 * @property string $company
 * @property string $company_name
 * @property int $_lft
 * @property int $_rgt
 * @property int $parent_id
 *
 * @property User $user
 * @property Employee $parent
 * @property Employee[]|Collection $children
 * @property Employee[]|Collection $ancestors
 * @property Employee[]|Collection $descendants
 */
class Employee extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'company',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        '_lft',
        '_rgt',
    ];

    protected $appends = [
        'company_name',
    ];

    public function getCompanyNameAttribute(): string
    {
        return $this->company ?: $this->parent->company_name;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isSelfTree(Employee $employee): bool
    {
        return $this->_lft <= $employee->_lft
            && $this->_rgt >= $employee->_rgt;
    }
}
