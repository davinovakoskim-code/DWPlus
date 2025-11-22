<?php

namespace EquipmentGroups;

use Carbon\Carbon;
use EquipmentSubgroups\EquipmentSubgroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class EquipmentGroup extends Model
{
    public const ID         = 'id';
    public const NAME       = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE = 'equipment_groups';

    protected $table = self::TABLE;

    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public function subgroups(): HasMany
    {
        return $this->hasMany(EquipmentSubgroup::class, EquipmentSubgroup::GROUP_ID);
    }
}
