<?php

declare(strict_types=1);

namespace App\Domain\Shared\Helper;

class StrHelper
{
    public static function camelCase(string $string): string
    {
        return lcfirst(self::studly($string));
    }

    public static function studly(string $string): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $string));

        return str_replace(' ', '', $value);
    }

    public static function snakeCase(string $string): string
    {
        return strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', $string), '_'));
    }
}
