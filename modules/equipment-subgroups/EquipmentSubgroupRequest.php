<?php

namespace EquipmentSubgroups;

use EquipmentGroups\EquipmentGroup;
use Illuminate\Validation\Rule;
use Kascat\EasyModule\Core\Request;

class EquipmentSubgroupRequest extends Request
{
    public function validateToStore(): array
    {
        return [
            EquipmentSubgroup::GROUP_ID => ['required', 'integer', Rule::exists(EquipmentGroup::TABLE, EquipmentGroup::ID)],
            EquipmentSubgroup::NAME     => ['required', 'string', 'max:150'],
        ];
    }

    public function validateToUpdate(): array
    {
        return [
            EquipmentSubgroup::GROUP_ID => ['sometimes', 'integer', Rule::exists(EquipmentGroup::TABLE, EquipmentGroup::ID)],
            EquipmentSubgroup::NAME     => ['sometimes', 'string', 'max:150'],
        ];
    }
}
