<?php

namespace Departments;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Equipments\Equipment;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Department extends Model
{
    public const ID          = 'id';
    public const NAME        = 'name';
    public const DESCRIPTION = 'description';
    public const CREATED_AT  = 'created_at';
    public const UPDATED_AT  = 'updated_at';

    public const TABLE = 'departments';

    protected $table = self::TABLE;

    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, Equipment::DEPARTMENT_ID);
    }
}
