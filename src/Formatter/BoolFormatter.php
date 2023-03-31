<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Formatter;

class BoolFormatter
{
    public static function format(bool $value): string
    {
        return $value ? 'Ja' : 'Off';
    }
}
