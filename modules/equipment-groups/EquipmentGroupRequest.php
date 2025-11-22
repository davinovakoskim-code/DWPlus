<?php

namespace EquipmentGroups;

use Kascat\EasyModule\Core\Request;

class EquipmentGroupRequest extends Request
{
    public function validateToStore(): array
    {
        return [
            EquipmentGroup::NAME => ['required', 'string', 'max:150'],
        ];
    }

    public function validateToUpdate(): array
    {
        return [
            EquipmentGroup::NAME => ['sometimes', 'string', 'max:150'],
        ];
    }
}
