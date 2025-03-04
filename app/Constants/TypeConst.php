<?php

namespace App\Constants;

class TypeConst
{
    /** @const */
    public const INCOME = "income";

    /** @const */
    public const EXPENSE = "expense";

    /**
     * @param string $type
     * @return string
     */
    public static function getTypeName(string $type): string
    {
        return $type === static::INCOME ? __('site.user.income') : __('site.user.expense');
    }
}
