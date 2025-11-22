<?php

namespace Locations;

use Kascat\EasyModule\Core\Request;

class LocationRequest extends Request
{
    public function validateToStore(): array
    {
        return [
            Location::NAME  => ['required', 'string', 'max:150'],
            Location::SCOPE => ['nullable', 'string', 'max:150'],
        ];
    }

    public function validateToUpdate(): array
    {
        return [
            Location::NAME  => ['sometimes', 'string', 'max:150'],
            Location::SCOPE => ['sometimes', 'nullable', 'string', 'max:150'],
        ];
    }
}
