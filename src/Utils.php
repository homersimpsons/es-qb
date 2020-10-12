<?php

declare(strict_types=1);

namespace EsQb;

final class Utils
{
    /**
     * @param array<string, mixed> $array
     * @param mixed                $value
     * @param mixed                $default
     */
    public static function printIfNotDefault(array &$array, string $field, $value, $default): void
    {
        if ($value === $default) {
            return;
        }

        $array[$field] = $value;
    }
}
