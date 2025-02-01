<?php

namespace Cable8mm\GoodCodeParser\Tests;

use Cable8mm\GoodCodeParser\GoodCodeParser;
use Cable8mm\GoodCodeParser\Parsers\SetGood;
use PHPUnit\Framework\TestCase;

class SetGoodTest extends TestCase
{
    public function test_set_good_codes_can_be_parsed()
    {
        // Arrange
        $input = 'set11319x1ZZ11626x1ZZ11624x1ZZ11628x1';

        $expect = [
            '11319' => 1,
            '11626' => 1,
            '11624' => 1,
            '11628' => 1,
        ];

        // Act
        $parsed = (new GoodCodeParser($input))->with(SetGood::class)->get();

        // Assert
        $this->assertEquals($parsed, $expect);
    }

    public function test_multi_set_good_codes_can_be_parsed()
    {
        // Arrange
        $input = 'set107253x1ZZ102257ZZ104128x2';

        $expect = [
            '107253' => 1,
            '102257' => 1,
            '104128' => 2,
        ];

        // Act
        $parsed = (new GoodCodeParser($input))->with(SetGood::class)->get();

        // Assert
        $this->assertEquals($parsed, $expect);
    }
}
