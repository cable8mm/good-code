<?php

namespace Cable8mm\GoodCodeParser\Tests;

use Cable8mm\GoodCodeParser\Enums\GoodCodeType;
use PHPUnit\Framework\TestCase;

class GoodCodeTypeTest extends TestCase
{
    public function test_make_set_code_method()
    {
        // Arrange
        $goodCodes = [
            '72363' => GoodCodeType::NORMAL,
            'set387234x1zz373x4' => GoodCodeType::SET,
            'opt10' => GoodCodeType::OPTION,
            'com10' => GoodCodeType::COMPLEX,
            'gif10' => GoodCodeType::GIFT,
        ];

        foreach ($goodCodes as $goodCode => $goodCodeType) {
            // Act
            $type = GoodCodeType::of($goodCode);

            // Assert
            $this->assertEquals($type, $goodCodeType);

        }
    }
}
