<?php

namespace Equipments;

use Carbon\Carbon;
use Departments\Department;
use EquipmentGroups\EquipmentGroup;
use EquipmentSubgroups\EquipmentSubgroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Locations\Location;
use App\Models\User;

class Equipment extends Model
{
    
    public const ID                  = 'id';
    public const ASSET_CODE          = 'asset_code';
    public const NAME                = 'name';
    public const DESCRIPTION         = 'description';
    
    public const GROUP_ID            = 'group_id';
    public const SUBGROUP_ID         = 'subgroup_id';
    
    public const STATUS              = 'status';
    public const DEPARTMENT_ID       = 'department_id';
    public const LOCATION_ID         = 'location_id';
    
    
    public const RENTED              = 'is_rented';   
    
    public const ATTACHMENT_NAME     = 'attachment_filename';
    
    public const CREATED_BY          = 'created_by';
    public const UPDATED_BY          = 'updated_by';
    
    public const CREATED_AT          = 'created_at';
    public const UPDATED_AT          = 'updated_at';

    public const TABLE = 'equipments';

    protected $table = self::TABLE;

    protected $fillable = [
        self::ASSET_CODE,
        self::NAME,
        self::DESCRIPTION,
        self::STATUS,
        self::LOCATION_ID,
        self::DEPARTMENT_ID,
        self::GROUP_ID,
        self::SUBGROUP_ID,
        self::RENTED,           
        self::ATTACHMENT_NAME,
        self::CREATED_BY,
        self::UPDATED_BY,
    ];

    protected $casts = [
        self::RENTED => 'boolean', 
    ];

    // --- RELACIONAMENTOS ---

    public function group(): BelongsTo
    {
        return $this->belongsTo(EquipmentGroup::class, self::GROUP_ID);
    }

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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, self::CREATED_BY);
    }
}