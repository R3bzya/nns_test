<?php

namespace App\Http\Controllers\Employee;

use App\Components\Transfer;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Models\Employee\Employee;
use App\Models\User\User;
use App\Services\Employee\EmployeeAttachParentService;
use App\Services\Employee\EmployeeCreateService;
use App\Services\User\UserCreateService;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends BaseController
{
    public function create(EmployeeCreateRequest $request)
    {
        $user = $this->withTransaction(function () use ($request) {
            $user = new User();
            $transfer = new Transfer($request->toArray());

            if ((new UserCreateService($user, $transfer))->run()) {
                if ((new EmployeeCreateService(new Employee(), $user, $transfer))->run()) {
                    if ((new EmployeeAttachParentService($user->employee, Auth::user()->employee))->run()) {
                        return $user;
                    }
                }
            }

            throw new \RuntimeException('Employee creating error!');
        });

        return $this->response($user);
    }

    public function children(Employee $employee)
    {
        return $this->response($employee->children);
    }

    public function descendants(Employee $employee)
    {
        return $this->response($employee->descendants);
    }
}
