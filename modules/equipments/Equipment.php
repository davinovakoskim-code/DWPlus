<?php

namespace Equipments;

use Carbon\Carbon;
use Departments\Department;
use EquipmentSubgroups\EquipmentSubgroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Locations\Location;

/**
 * @property int $id
 * @property string $asset_code
 * @property string $name
 * @property string|null $description
 * @property int $subgroup_id
 * @property string $status
 * @property int $department_id
 * @property int $location_id
 * @property bool $rented
 * @property string|null $attachment_filename
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Equipment extends Model
{
    public const ID                = 'id';
    public const ASSET_CODE        = 'asset_code';
    public const NAME              = 'name';
    public const DESCRIPTION       = 'description';
    public const SUBGROUP_ID       = 'subgroup_id';
    public const STATUS            = 'status';
    public const DEPARTMENT_ID     = 'department_id';
    public const LOCATION_ID       = 'location_id';
    public const RENTED            = 'rented';
    public const ATTACHMENT_NAME   = 'attachment_filename';
    public const CREATED_AT        = 'created_at';
    public const UPDATED_AT        = 'updated_at';

    public const TABLE = 'equipments';

    protected $table = self::TABLE;

    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    protected $casts = [
        self::RENTED => 'boolean',
    ];

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(EquipmentSubgroup::class, self::SUBGROUP_ID);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, self::DEPARTMENT_ID);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, self::LOCATION_ID);
    }
}
