<?php

namespace App\Helper;

class ValidationHelper
{
    public static function isDashboardFilterValidation(array $filters): bool
    {
        return isset($filters['year']) && isset($filters['month']) && ($filters['year'] && $filters['month']);
    }
}
