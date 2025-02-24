<?php

namespace Cable8mm\GoodCode;

use Stringable;

/**
 * This class represents a SKU identified by code and prefix. The SKU is generated from these properties.
 *
 * @author Samgu Lee <cable8mm@gmail.com>
 *
 * @since  2025-02-24
 */
class Sku implements Stringable
{
    /**
     * Code representing the SKU
     *
     * @example BO123
     */
    private string $sku;

    private function __construct(
        /**
         * The code for the sku
         *
         * @example 123
         */
        private string|int $code,
        /**
         * Prefix
         *
         * @example BO
         */
        private ?string $prefix = null
    ) {
        $this->sku = $prefix.$code;
    }

    /**
     * Get the SKU.
     *
     * @return string The method returns the SKU
     *
     * @example print Sku::of(123, prefix: 'BO');    => 'BO123'
     */
    public function sku(): string
    {
        return $this->sku;
    }

    /**
     * Create a new SKU instance.
     *
     * @param  string|int  $code  The SKU
     * @param  string|null  $prefix  Prefix for the SKU
     * @return self Provides fluent interface
     *
     * @throws \InvalidArgumentException
     */
    public static function of(
        string|int|array $code,
        ?string $prefix = null
    ): self {
        if (is_array($code)) {
            $disallowedKeys = array_diff_key($code, array_flip(['code', 'prefix']));

            if (! empty($disallowedKeys)) {
                throw new \InvalidArgumentException('Invalid key(s): '.implode(', ', array_keys($disallowedKeys)));
            }

            return new self(
                code: $code['code'],
                prefix: $code['prefix'] ?? null
            );
        }

        return new self(
            code: $code,
            prefix: $prefix
        );
    }

    /**
     * Get the string representation of the SKU.
     *
     * @return string The magic method returns the SKU
     *
     * @example print Sku::of('1') => 'A1'
     * @example print Sku::of('1', prefix: 'BO') => 'BO1'
     */
    public function __toString(): string
    {
        return $this->sku;
    }
}
