<?php

namespace Cable8mm\GoodCode\Tests\ValueObjects;

use Cable8mm\GoodCode\ValueObjects\SetGood;
use PHPUnit\Framework\TestCase;

class SetGoodTest extends TestCase
{
    public function test_create_instance_with_string()
    {
        $setGood = SetGood::of('SET43x3zz253x3');

        $this->assertEquals(['43' => 3, '253' => 3], $setGood->goods());
    }

    public function test_create_instance_with_array()
    {
        $setGood = SetGood::ofArray(['43' => 3, '253' => 3]);

        $this->assertEquals('SET43x3zz253x3', $setGood->code());
    }

    public function test_fire_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('It is not valid code');

        SetGood::of('sdf23brew');
    }
}
