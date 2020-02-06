<?php

declare(strict_types=1);

namespace App\Domain\Parser;

use DateTime;
use DateTimeImmutable;

class DateParser
{
    public static function parse(string $date): DateTime
    {
        $parsedDate = DateTime::createFromFormat(DateTime::ATOM, $date);

        if ($parsedDate === false) {
            // Be warned that without providing time PHP will use the current time
            $parsedDate = DateTime::createFromFormat('d/m/Y H:i:s', $date . ' 00:00:00');
        }

        if ($parsedDate === false) {
            $parsedDate = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        }

        return $parsedDate;
    }

    public static function parseImmutable(string $date): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable(self::parse($date));
    }
}
