<?php

namespace App\Repositories\User;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{

    /**
     * @param User $user
     * @param array $data
     * @return void
     */
    public function save(User $user, array $data): void
    {
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
        $user->save();
    }
}
