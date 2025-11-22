<?php

namespace Equipments;

use Departments\Department;
use EquipmentSubgroups\EquipmentSubgroup;
use Illuminate\Validation\Rule;
use Kascat\EasyModule\Core\Request;
use Locations\Location;

class EquipmentRequest extends Request
{
    public function validateToStore(): array
    {
        return [
            Equipment::ASSET_CODE      => ['required', 'string', 'max:50', Rule::unique(Equipment::TABLE, Equipment::ASSET_CODE)],
            Equipment::NAME            => ['required', 'string', 'max:150'],
            Equipment::DESCRIPTION     => ['nullable', 'string'],
            Equipment::SUBGROUP_ID     => ['required', 'integer', Rule::exists(EquipmentSubgroup::TABLE, EquipmentSubgroup::ID)],
            Equipment::STATUS          => ['required', 'string', 'max:50'],
            Equipment::DEPARTMENT_ID   => ['required', 'integer', Rule::exists(Department::TABLE, Department::ID)],
            Equipment::LOCATION_ID     => ['required', 'integer', Rule::exists(Location::TABLE, Location::ID)],
            Equipment::RENTED          => ['required', 'boolean'],
            Equipment::ATTACHMENT_NAME => ['nullable', 'string', 'max:255'],
        ];
    }

    public function validateToUpdate(): array
    {
        /** @var Equipment|null $equipment */
        $equipment = $this->route('equipment');

        return [
            Equipment::ASSET_CODE      => ['sometimes', 'string', 'max:50', Rule::unique(Equipment::TABLE, Equipment::ASSET_CODE)->ignore($equipment?->id)],
            Equipment::NAME            => ['sometimes', 'string', 'max:150'],
            Equipment::DESCRIPTION     => ['sometimes', 'nullable', 'string'],
            Equipment::SUBGROUP_ID     => ['sometimes', 'integer', Rule::exists(EquipmentSubgroup::TABLE, EquipmentSubgroup::ID)],
            Equipment::STATUS          => ['sometimes', 'string', 'max:50'],
            Equipment::DEPARTMENT_ID   => ['sometimes', 'integer', Rule::exists(Department::TABLE, Department::ID)],
            Equipment::LOCATION_ID     => ['sometimes', 'integer', Rule::exists(Location::TABLE, Location::ID)],
            Equipment::RENTED          => ['sometimes', 'boolean'],
            Equipment::ATTACHMENT_NAME => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
