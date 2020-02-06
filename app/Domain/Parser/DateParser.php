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
            $parsedDate = DateTime::createFromFormat('d/m/Y', $date);
        }

        if ($parsedDate === false) {
            $parsedDate = DateTime::createFromFormat('Y-m-d h:m:s', $date);
        }

        return $parsedDate;
    }

    public static function parseImmutable(string $date): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable(self::parse($date));
    }
}
