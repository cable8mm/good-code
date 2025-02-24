<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\Sku;
use PHPUnit\Framework\TestCase;

class SkuTest extends TestCase
{
    public function test_full_sku()
    {
        $this->assertEquals('PO123', Sku::of([
            'code' => 123,
            'prefix' => 'PO',
        ]));
    }

    public function test_sku_without_prefix()
    {
        $this->assertEquals('123', Sku::of([
            'code' => 123,
        ]));
    }

    public function test_sku_with_wrong_code()
    {
        $this->expectException(\InvalidArgumentException::class);

        Sku::of([
            'wrong' => 'key',
        ]);
    }
}
