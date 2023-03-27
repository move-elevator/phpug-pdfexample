<?php

declare(strict_types = 1);

namespace MoveElevator\SputnikPdfForm\Formatter;

use Money\Money;

class FieldValuesFormatter
{
    public static function format(array $fieldValues): array
    {
        $formattedFieldValues = [];

        foreach ($fieldValues as $fieldName => $fieldValue) {
            if (true === is_bool($fieldValue)) {
                $formattedFieldValues[$fieldName] = BoolFormatter::format($fieldValue);
                continue;
            }

            if (true === $fieldValue instanceof Money) {
                $formattedFieldValues[$fieldName] = MoneyFormatter::format($fieldValue);
                continue;
            }

            $formattedFieldValues[$fieldName] = $fieldValue;
        }

        return $formattedFieldValues;
    }
}
