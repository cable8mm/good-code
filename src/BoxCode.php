<?php

namespace Cable8mm\GoodCode;

use Stringable;

/**
 * This class represents a box code identified by code and prefix. The box code is generated from these properties.
 *
 * @author Samgu Lee <cable8mm@gmail.com>
 *
 * @since  2025-02-24
 */
class BoxCode implements Stringable
{
    /**
     * Code representing the box
     *
     * @example BO123
     */
    private string $boxCode;

    private function __construct(
        /**
         * Box code
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
        $this->boxCode = $prefix.$code;
    }

    /**
     * Get the box code.
     *
     * @return string The method returns the box code
     *
     * @example print BoxCode::of(123, prefix: 'BO')->boxCode();    => 'BO123'
     * @example print BoxCode::of(123, prefix: 'BO');               => 'BO123'
     */
    public function boxCode(): string
    {
        return $this->boxCode;
    }

    /**
     * Create a new box code instance.
     *
     * @param  string|int  $code  The box code
     * @param  string|null  $prefix  Prefix for the box code
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
     * Get the string representation of the box code.
     *
     * @return string The magic method returns the box code
     *
     * @example print BoxCode::of('1') => 'A1'
     * @example print BoxCode::of('1', prefix: 'BO') => 'BO1'
     */
    public function __toString(): string
    {
        return $this->boxCode;
    }
}
