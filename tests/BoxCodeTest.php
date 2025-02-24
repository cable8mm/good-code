<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\BoxCode;
use PHPUnit\Framework\TestCase;

class BoxCodeTest extends TestCase
{
    public function test_full_box_code()
    {
        $this->assertEquals('PO123', BoxCode::of(
            123,
            prefix: 'PO'
        )->boxCode());

        $this->assertEquals('PO123', BoxCode::of([
            'code' => 123,
            'prefix' => 'PO',
        ]));
    }

    public function test_box_code_without_prefix()
    {
        $this->assertEquals('123', BoxCode::of(
            123
        )->boxCode());

        $this->assertEquals('123', BoxCode::of([
            'code' => 123,
        ]));
    }

    public function test_location_code_with_empty()
    {
        $this->expectException(\InvalidArgumentException::class);

        BoxCode::of([
            'wrong' => 'key',
        ]);
    }
}
