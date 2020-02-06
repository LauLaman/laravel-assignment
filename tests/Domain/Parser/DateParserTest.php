<?php

declare(strict_types=1);

namespace Tests\Domain\Parser;

use App\Domain\Parser\DateParser;
use DateTime;
use PHPUnit\Framework\TestCase;

class DateParserTest extends TestCase
{
    /**
     * @dataProvider getDataToParse()
     */
    public function testParse($input, $expectedOutput): void
    {
        $parsed = DateParser::parse($input);

        $this->assertEquals($expectedOutput, $parsed);
    }

    public function getDataToParse(): array
    {
        return [
            'ATOM' => ['1989-03-21T01:11:13+00:00', new DateTime('1989-03-21T01:11:13+00:00')],
            'd/m/Y' => ['15/09/1978', new DateTime('1978-09-15 00:00:00')],
            'Y-m-d H:i:s' => ['1955-12-05 00:00:00', new DateTime('1955-12-05 00:00:00')],
        ];
    }
}
