<?php

namespace App\Services\Common;

class ClearService
{
    /**
     * @return void
     */
    public function clearUserSession(): void
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
