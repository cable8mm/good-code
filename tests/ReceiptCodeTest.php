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
        $this->assertEquals('PO-20250312-0001', ReceiptCode::of('PO-20250312-0001')->code);
        $this->assertEquals('PO', ReceiptCode::of('PO-20250312-0001')->prefix);
        $this->assertEquals('20250312', ReceiptCode::of('PO-20250312-0001')->ymd);
        $this->assertEquals('0001', ReceiptCode::of('PO-20250312-0001')->number);
    }

    public function test_next_code_method()
    {
        $today = date('Ymd');
        $this->assertEquals('PO-'.$today.'-0002', ReceiptCode::of('PO-'.$today.'-0001')->nextCode());
        $this->assertEquals('PO-'.$today.'-10000', ReceiptCode::of('PO-'.$today.'-9999')->nextCode());
    }

    public function test_no_code()
    {
        $this->assertEquals('PO-'.date('Ymd').'-0001', ReceiptCode::of()->nextCode());
    }

    public function test_prefix()
    {
        $this->assertEquals('CT', ReceiptCode::of(prefix: 'CT')->prefix);
    }

    public function test_next_code_with_different_date()
    {
        // This test verifies that nextCode() resets to 0001 when date changes
        // We can't easily test actual date changes, but we can test the logic
        $receiptCode = ReceiptCode::of('PO-20250101-0001');

        // If today is not 20250101, it should return today's date with 0001
        $nextCode = $receiptCode->nextCode();
        $today = date('Ymd');

        // Verify the format is correct
        $this->assertMatchesRegularExpression('/^PO-'.$today.'-0001$/', $nextCode);
    }

    public function test_invalid_code_format()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid code format.');

        ReceiptCode::of('INVALID_CODE');
    }

    public function test_code_with_single_dash()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid code format.');

        ReceiptCode::of('PO-20250312');
    }

    public function test_receipt_code_with_zero_number()
    {
        $receiptCode = ReceiptCode::of('PO-20250312-0000');

        $this->assertEquals('PO-20250312-0000', $receiptCode->code);
        $this->assertEquals('0000', $receiptCode->number);
    }

    public function test_receipt_code_next_with_zero()
    {
        $today = date('Ymd');
        $this->assertEquals('PO-'.$today.'-0001', ReceiptCode::of('PO-'.$today.'-0000')->nextCode());
    }

    public function test_receipt_code_with_special_prefix()
    {
        $receiptCode = ReceiptCode::of('IN-20250312-0001');

        $this->assertEquals('IN', $receiptCode->prefix);
        $this->assertEquals('20250312', $receiptCode->ymd);
        $this->assertEquals('0001', $receiptCode->number);
    }

    public function test_receipt_code_to_string()
    {
        $this->assertEquals('PO-20250312-0001', (string) ReceiptCode::of('PO-20250312-0001'));
    }

    public function test_receipt_code_to_string_empty()
    {
        $this->assertEquals('', (string) ReceiptCode::of());
    }
}
