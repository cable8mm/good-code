<?php

namespace Cable8mm\GoodCode;

use InvalidArgumentException;
use Stringable;

/**
 * This class represents a receipt code identified by code, prefix, ymd and number. The receipt code is generated from these properties.
 *
 * @author Samgu Lee <cable8mm@gmail.com>
 *
 * @since  2025-02-21
 */
class ReceiptCode implements Stringable
{
    /**
     * Year month day of the receipt code
     */
    public string $ymd;

    /**
     * Number of the receipt code
     */
    public int $number;

    /**
     * Receipt code
     */
    public string $code;

    /**
     * ReceiptCode constructor.
     *
     * @param  string|null  $code  ReceiptCode
     */
    private function __construct(
        /**
         * Prefix of the receipt code
         */
        public string $prefix,
        ?string $code = null
    ) {
        if (! is_null($code)) {
            $this->code($code);
        }
    }

    /**
     * Parse code and set `code`, `prefix`, `ymd` and `number`.
     *
     * @param  string  $code  ReceiptCode
     * @return static Provides a fluent interface
     */
    public function code(string $code): static
    {
        if (preg_match('/^([^\-]+)\-([^\-]+)\-(.+)$/', $code, $matches) === false) {
            throw new InvalidArgumentException('Invalid code format.');
        }

        [$this->code, $this->prefix, $this->ymd, $this->number] = $matches;

        return $this;
    }

    /**
     * Get next code.
     *
     * @return string Next code
     *
     * @example ReceiptCode::of()->nextCode() => PO-20250312-0001
     * @example ReceiptCode::of('PO-20250312-0001')->nextCode() => PO-20250312-0002
     * @example ReceiptCode::of('PO-20250312-9999')->nextCode() => PO-20250312-10000
     * @example ReceiptCode::of('PO-20250312-9999', prefix: 'CT')->nextCode() => CT-20250312-10000
     */
    public function nextCode(): string
    {
        if (! isset($this->code)) {
            return $this->prefix.'-'.date('Ymd').'-0001';
        }

        if ($this->ymd === $this->ymd) {
            return $this->prefix.'-'.$this->ymd.'-'.str_pad($this->number + 1, 4, '0', STR_PAD_LEFT);
        }

        return $this->prefix.'-'.date('Ymd').'-0001';
    }

    /**
     * Create a new instance of ReceiptCode.
     *
     * @param  string|null  $code  receipt code
     * @param  string|null  $prefix  prefix of the receipt code, default is 'PO'
     * @return static Provides a new instance of ReceiptCode
     */
    public static function of(?string $code = null, ?string $prefix = 'PO'): self
    {
        return is_null($code) ? new self(prefix: $prefix) : new self($prefix, $code);
    }

    /**
     * Get the string representation of the object.
     *
     * @return string The method returns the `code` representation
     */
    public function __toString(): string
    {
        return $this->code ?? '';
    }
}
