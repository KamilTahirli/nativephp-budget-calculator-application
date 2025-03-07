<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{

    public function save(User $user, array $data);
}
