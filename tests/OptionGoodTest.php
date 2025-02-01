<?php

namespace Cable8mm\GoodCodeParser\Tests;

use Cable8mm\GoodCodeParser\OptionCodeParser;
use Cable8mm\GoodCodeParser\Parsers\OptionGood;
use PHPUnit\Framework\TestCase;

class OptionGoodTest extends TestCase
{
    public function test_option_good_codes_can_be_parsed()
    {
        // Arrange
        $optionGoods = [
            ['id' => 1, 'code' => 'OPT1', 'name' => 'Nintendo Switch Super Sales'],
            ['id' => 2, 'code' => 'OPT2', 'name' => 'Playstation Super Sales'],
        ];

        $optionGoodOptions = [
            ['code' => 1, 'master_code' => 'COM4', 'name' => 'Super Smash Bros. Ultimate'],
            ['code' => 1, 'master_code' => '3124', 'name' => 'Animal Crossing: New Horizons'],
            ['code' => 1, 'master_code' => '1234', 'name' => 'The Legend of Zelda: Tears of the Kingdom'],
            ['code' => 1, 'master_code' => '4324', 'name' => 'Super Mario 3D World + Bowser\'s Fury'],
            ['code' => 2, 'master_code' => '2314', 'name' => 'Call of Duty®: Black Ops 6'],
            ['code' => 2, 'master_code' => '43123', 'name' => 'Grand Theft Auto V'],
            ['code' => 2, 'master_code' => '42342', 'name' => 'Marvel\'s Spider-Man 2'],
        ];

        $inOptionCode = 'OPT1';
        $inOptionName = 'Super Smash Bros. Ultimate';

        $output = 'COM4';

        // Act
        $parsed = (new OptionCodeParser($inOptionCode, $inOptionName))->with(OptionGood::class, $optionGoods, $optionGoodOptions)->get();

        // Assert
        $this->assertEquals($parsed, $output);
    }
}
