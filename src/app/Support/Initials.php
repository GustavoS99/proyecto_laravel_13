<?php

namespace App\Support;

class Initials
{
    public static function from(string $name): string
    {
        $words = preg_split('/\s+/u', trim($name), -1, PREG_SPLIT_NO_EMPTY);

        if ($words === []) {
            return '';
        }

        $letters = [mb_substr($words[0], 0, 1)];

        if (count($words) > 1) {
            $letters[] = mb_substr($words[array_key_last($words)], 0, 1);
        }

        return mb_strtoupper(implode('', $letters));
    }
}