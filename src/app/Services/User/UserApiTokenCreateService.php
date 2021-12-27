<?php

namespace App\Services\User;

use App\Models\User\User;
use App\Services\BaseService;

class UserApiTokenCreateService extends BaseService
{
    private User $user;
    private string $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function run(): bool
    {
        return $this->user->forceFill([
            'api_token' => hash('sha256', $this->token)
        ])->save();
    }
}
