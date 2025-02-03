<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\GoodCodeParser;
use Cable8mm\GoodCode\Parsers\ComplexGood;
use PHPUnit\Framework\TestCase;

class ComplexGoodTest extends TestCase
{
    public function test_complex_good_codes_can_be_parsed()
    {
        // Arrange
        $goods = [
            1 => 'set11319x1ZZ11626x1ZZ11624x1ZZ11628x1',
            2 => 'set11318x1ZZP3800x1ZZP7776x1ZZP9732x1',
            3 => 'set11318x1ZZP2526x1ZZP7776x1',
        ];

        $input = 'com2';

        $output = 'set11318x1ZZP3800x1ZZP7776x1ZZP9732x1';

        // Act
        $parsed = (new GoodCodeParser($input))->with(ComplexGood::class, $goods)->get();

        // Assert
        $this->assertEquals($parsed, $output);
    }
}
