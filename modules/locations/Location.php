<?php

namespace Locations;

use Carbon\Carbon;
use Equipments\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $scope
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Location extends Model
{
    public const ID         = 'id';
    public const NAME       = 'name';
    public const SCOPE      = 'scope';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE = 'locations';

    protected $table = self::TABLE;

    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, Equipment::LOCATION_ID);
    }
}
