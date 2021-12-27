<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\User\UserRegisterRequest;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = (new UserRegisterRequest())->rules();

        unset($rules['company']);
        unset($rules['parent_email']);

        return $rules;
    }
}
