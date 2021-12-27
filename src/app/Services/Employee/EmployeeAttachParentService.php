<?php

namespace App\Services\Employee;

use App\Models\Employee\Employee;
use App\Services\BaseService;

class EmployeeAttachParentService extends BaseService
{
    private Employee $employee;
    private ?Employee $parent;

    public function __construct(Employee $employee, ?Employee $parent)
    {
        $this->employee = $employee;
        $this->parent = $parent;
    }

    public function run(): bool
    {
        return ! is_null($this->parent) && $this->employee->appendToNode($this->parent)->save();
    }
}
