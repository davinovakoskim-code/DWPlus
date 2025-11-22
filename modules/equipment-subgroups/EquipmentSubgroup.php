<?php

namespace EquipmentSubgroups;

use Carbon\Carbon;
use EquipmentGroups\EquipmentGroup;
use Equipments\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class EquipmentSubgroup extends Model
{
    public const ID         = 'id';
    public const GROUP_ID   = 'group_id';
    public const NAME       = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE = 'equipment_subgroups';

    protected $table = self::TABLE;

    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(EquipmentGroup::class, self::GROUP_ID);
    }

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, Equipment::SUBGROUP_ID);
    }
}
