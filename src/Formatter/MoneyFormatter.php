<?php

declare(strict_types=1);

namespace MoveElevator\SputnikPdfForm\Formatter;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlLocalizedDecimalFormatter;
use Money\Money;
use NumberFormatter;

class MoneyFormatter
{
    public static function format(Money $value): string
    {
        $moneyFormatter = new IntlLocalizedDecimalFormatter(
            new NumberFormatter('de-DE', NumberFormatter::DECIMAL),
            new ISOCurrencies()
        );

        return $moneyFormatter->format($value);
    }
}
