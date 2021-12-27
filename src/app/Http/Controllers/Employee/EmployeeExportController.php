<?php

namespace App\Http\Controllers\Employee;

use App\Formatters\Employee\EmployeeChildrenFormatter;
use App\Http\Controllers\BaseController;
use App\Models\Employee\Employee;

class EmployeeExportController extends BaseController
{
    private EmployeeChildrenFormatter $formatter;

    public function __construct(EmployeeChildrenFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function children(Employee $employee)
    {
        $this->formatter->children($employee)->stream('children.pdf');
    }

    public function descendants(Employee $employee)
    {
        $this->formatter->descendants($employee)->stream('descendants.pdf');
    }
}
