<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\GoodCode;
use PHPUnit\Framework\TestCase;

class GoodCodeTest extends TestCase
{
    public function test_make_set_code_method()
    {
        // Arrange
        $setCode = [
            '1234' => 2,
            '5678' => 1,
        ];

        // Act
        $setCodeString = GoodCode::makeSetCode($setCode);

        // Assert
        $this->assertEquals('set1234x2ZZ5678x1', $setCodeString);
    }

    public function test_set_code_method()
    {
        // Arrange
        $setCodeString = 'set1234x2ZZ5678x1';

        // Act
        $setCodeArray = GoodCode::getSetCodes($setCodeString);

        // Assert
        $this->assertEquals([
            '1234' => 2,
            '5678' => 1,
        ], $setCodeArray);
    }

    public function test_get_id()
    {
        // Arrange
        $comCode = 'COM10';
        $comCode2 = 'GIF239';

        // Act
        $comId = GoodCode::getId($comCode);
        $comId2 = GoodCode::getId($comCode2);

        // Assert
        $this->assertEquals(10, $comId);
        $this->assertEquals(239, $comId2);
    }
}
