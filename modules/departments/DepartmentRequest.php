<?php

namespace Departments;

use Kascat\EasyModule\Core\Request;

class DepartmentRequest extends Request
{
    public function validateToStore(): array
    {
        return [
            Department::NAME        => ['required', 'string', 'max:150'],
            Department::DESCRIPTION => ['nullable', 'string'],
        ];
    }

    public function validateToUpdate(): array
    {
        return [
            Department::NAME        => ['sometimes', 'string', 'max:150'],
            Department::DESCRIPTION => ['sometimes', 'nullable', 'string'],
        ];
    }
}
