<?php

namespace App\Services\Employee;

use App\Components\Transfer;
use App\Models\Employee\Employee;
use App\Models\User\User;
use App\Services\BaseService;

class EmployeeCreateService extends BaseService
{
    private Employee $employee;
    private User $user;
    private Transfer $transfer;

    public function __construct(Employee $employee, User $user, Transfer $transfer)
    {
        $this->employee = $employee;
        $this->user = $user;
        $this->transfer = $transfer;
    }

    public function run(): bool
    {
        return $this->employee->fill([
            'name' => $this->transfer->get('name'),
            'company' => $this->transfer->get('company'),
            'user_id' => $this->user->id,
        ])->save();
    }
}
