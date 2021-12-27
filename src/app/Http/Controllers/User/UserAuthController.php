<?php

namespace App\Http\Controllers\User;

use App\Components\Transfer;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Models\Employee\Employee;
use App\Models\User\User;
use App\Services\Employee\EmployeeAttachParentService;
use App\Services\Employee\EmployeeCreateService;
use App\Services\User\UserCreateService;
use App\Services\User\UserApiTokenCreateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserAuthController extends BaseController
{
    public function register(UserRegisterRequest $request)
    {
        $user = $this->withTransaction(function () use ($request) {
            $user = new User();
            $transfer = new Transfer($request->toArray());

            if ((new UserCreateService($user, $transfer))->run()) {
                if ((new EmployeeCreateService(new Employee(), $user, $transfer))->run()) {
                    if ((new EmployeeAttachParentService($user->employee, $request->getParentEmployee()))->run()
                        || ! $request->getParentEmployee()) {
                        return $user;
                    }
                }
            }

            throw new \RuntimeException('User registering error!');
        });

        return $this->response($user);
    }

    public function login(UserLoginRequest $request)
    {
        if (! Auth::attempt($request->toArray())) {
            return $this->response(['message' => 'The provided credentials do not match our records.']);
        }

        $token = $this->withTransaction(function () {
            $token = Str::random(60);

            if ((new UserApiTokenCreateService(Auth::user(), $token))->run()) {
                return $token;
            }

            throw new \RuntimeException('Token creating error!');
        });

        return $this->response(['token' => $token]);
    }
}
