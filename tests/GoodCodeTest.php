<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\GoodCode;
use PHPUnit\Framework\TestCase;

class GoodCodeTest extends TestCase
{
    public function test_make_set_code()
    {
        // Arrange
        $setCode = [
            '1234' => 2,
            '5678' => 1,
        ];

        // Act
        $setCode = GoodCode::setCodeOf($setCode);

        // Assert
        $this->assertEquals('SET1234x2zz5678x1', $setCode->code());
    }

    public function test_make_set_code_array()
    {
        // Arrange
        $setCodeString = 'SET1234x2zz5678x1';

        // Act
        $code = GoodCode::of($setCodeString);

        // Assert
        $this->assertEquals([
            '1234' => 2,
            '5678' => 1,
        ], $code->value());
    }

    public function test_complex_code()
    {
        // Arrange
        $comCode = 'COM10';

        // Act
        $code = GoodCode::of($comCode, callback: function ($key) {
            $a = [
                10 => '123',
            ];

            return $a[$key];
        });

        // Assert
        $this->assertEquals('123', $code->value());
    }

    public function test_gift_code()
    {
        // Arrange
        $comCode = 'GIF11';

        // Act
        $code = GoodCode::of($comCode, callback: function ($key) {
            $a = [
                11 => '456',
            ];

            return $a[$key];
        });

        // Assert
        $this->assertEquals('456', $code->value());
    }

    public function test_option_code()
    {
        // Arrange
        $optionCode = 'OPT10';
        $optionName = 'Animal Crossing: New Horizons';

        // Act
        $code = GoodCode::of($optionCode, option: $optionName, callback: function ($key, $option) {
            $a = [
                10 => [
                    'Super Smash Bros. Ultimate' => 'COM4',
                    'Animal Crossing: New Horizons' => '3124',
                    'The Legend of Zelda: Tears of the Kingdom' => '1234',
                    'Call of Duty®: Black Ops 6' => '2314',
                    'Grand Theft Auto V' => '43123',
                    '42342', 'name' => 'Marvel\'s Spider-Man 2',
                ],
            ];

            return $a[$key][$option];
        });

        // Assert
        $this->assertEquals('3124', $code->value());
    }
}
