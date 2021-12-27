<?php

namespace App\Http\Requests\User;

use App\Models\Employee\Employee;
use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|confirmed|min:6|max:32',
            'company' => 'required_without:parent_email|string|min:3|max:255',
            'parent_email' => 'required_without:company|email|exists:users,email'
        ];
    }

    public function getParentEmployee(): ?Employee
    {
        /** @var User $user */
        $user = User::firstWhere(['email' => $this->get('parent_email')]);

        return $user ? $user->employee : null;
    }
}
