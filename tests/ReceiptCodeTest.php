<?php

namespace Cable8mm\GoodCode\Tests;

use Cable8mm\GoodCode\ReceiptCode;
use PHPUnit\Framework\TestCase;

class ReceiptCodeTest extends TestCase
{
    public function test_of_method()
    {
        $this->assertEquals('PO-20250312-0001', ReceiptCode::of('PO-20250312-0001')->code);
    }

    public function test_code_method()
    {
        $this->assertEquals('PO-20250312-0001', ReceiptCode::make()->code('PO-20250312-0001')->code);
        $this->assertEquals('PO', ReceiptCode::make()->code('PO-20250312-0001')->prefix);
        $this->assertEquals('20250312', ReceiptCode::make()->code('PO-20250312-0001')->ymd);
        $this->assertEquals('0001', ReceiptCode::make()->code('PO-20250312-0001')->number);
    }

    public function test_next_code_method()
    {
        $this->assertEquals('PO-20250312-0002', ReceiptCode::make()->code('PO-20250312-0001')->nextCode());
        $this->assertEquals('PO-20250312-10000', ReceiptCode::make()->code('PO-20250312-9999')->nextCode());
    }

    public function test_no_code()
    {
        $this->assertEquals('PO-'.date('Ymd').'-0001', ReceiptCode::make()->nextCode());
    }
}
