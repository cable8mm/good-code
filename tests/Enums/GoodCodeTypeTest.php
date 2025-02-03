<?php

namespace Cable8mm\GoodCode\Tests\Enums;

use Cable8mm\GoodCode\Enums\GoodCodeType;
use PHPUnit\Framework\TestCase;

class GoodCodeTypeTest extends TestCase
{
    public function test_good_code_type_class()
    {
        // Arrange
        $goodCodes = [
            '72363' => GoodCodeType::NORMAL,
            'SET387234x1zz373x4' => GoodCodeType::SET,
            'OPT10' => GoodCodeType::OPTION,
            'COM10' => GoodCodeType::COMPLEX,
            'GIF10' => GoodCodeType::GIFT,
        ];

        foreach ($goodCodes as $goodCode => $goodCodeType) {
            // Act
            $type = GoodCodeType::of($goodCode);

            // Assert
            $this->assertEquals($type, $goodCodeType);

        }
    }
}
