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

    public function test_set_good_with_missing_count()
    {
        $this->expectException(\InvalidArgumentException::class);

        SetGood::of('SET1234x');
    }

    public function test_set_good_with_missing_good_code()
    {
        $this->expectException(\InvalidArgumentException::class);

        SetGood::of('SETx3');
    }

    public function test_set_good_with_invalid_format()
    {
        $this->expectException(\InvalidArgumentException::class);

        SetGood::of('SET1234x3x5');
    }

    public function test_set_good_with_empty_string()
    {
        $this->expectException(\InvalidArgumentException::class);

        SetGood::of('');
    }

    public function test_set_good_with_multiple_delimiters()
    {
        $setGood = SetGood::of('SET1234x3zz5678x2zz9012x1');

        $this->assertEquals([
            '1234' => 3,
            '5678' => 2,
            '9012' => 1,
        ], $setGood->goods());
    }
}
