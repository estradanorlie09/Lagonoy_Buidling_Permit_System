<?php

namespace App\Utils;

class StringHelper
{
    public static function normalizeName(string $name): string
    {
        $name = preg_replace('/\s+/', ' ', $name); // normalize spacing
        return strtoupper(trim($name));
    }
}
