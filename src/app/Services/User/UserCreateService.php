<?php

namespace App\Services\User;

use App\Components\Transfer;
use App\Models\User\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

class UserCreateService extends BaseService
{
    private User $user;
    private Transfer $transfer;

    public function __construct(User $user, Transfer $transfer)
    {
        $this->user = $user;
        $this->transfer = $transfer;
    }

    public function run(): bool
    {
        return $this->user->fill([
            'email' => $this->transfer->get('email'),
            'password' => Hash::make($this->transfer->get('password'))
        ])->save();
    }
}
