<?php

namespace App\Support;

use Carbon\Carbon;

class DateInput
{
    public static function normalize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        foreach (['m/d/Y', 'n/j/Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $trimmed)->format('Y-m-d');
            } catch (\Throwable) {
            }
        }

        return $trimmed;
    }
}