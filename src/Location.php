<?php

namespace Cable8mm\GoodCode;

use Stringable;

class Location implements Stringable
{
    /**
     * Code representing the product’s storage location
     *
     * @example A1-B3-S5
     */
    private string $locationCode;

    private function __construct(
        /**
         * Warehouse ID (for multi-warehouse management)
         *
         * @example AUK
         * @example SEL
         */
        private ?string $warehouse = null,
        /**
         * Rack number
         *
         * @example R3
         * @example S5
         */
        private ?string $rack = null,
        /**
         * Shelf number
         *
         * @example S5
         * @example F7
         */
        private ?string $shelf = null,
    ) {
        if (is_null($warehouse) && is_null($rack) && is_null($shelf)) {
            throw new \InvalidArgumentException('At least one parameter must be provided.');
        }

        $this->warehouse = $warehouse ?? '';
        $this->rack = $rack ?? '';
        $this->shelf = $shelf ?? '';

        $this->locationCode = implode('-', array_filter([
            $this->warehouse,
            $this->rack,
            $this->shelf,
        ]));

        $this->locationCode = preg_replace('/-+/', '-', $this->locationCode);
    }

    public function locationCode(): string
    {
        return $this->locationCode;
    }

    /**
     * Create a new Location instance.
     *
     * @param  string|array|null  $warehouse  Warehouse ID or array of arguments
     * @param  string|null  $rack  Rack
     * @param  string|null  $shelf  Shelf
     * @return self Provides fluent interface
     *
     * @throws \InvalidArgumentException
     */
    public static function of(
        string|array|null $warehouse = null,
        ?string $rack = null,
        ?string $shelf = null
    ): self {
        if (is_array($warehouse)) {
            if (empty($warehouse)) {
                throw new \InvalidArgumentException('At least one parameter must be provided.');
            }

            $disallowedKeys = array_diff_key($warehouse, array_flip(['warehouse', 'rack', 'shelf']));

            if (! empty($disallowedKeys)) {
                throw new \InvalidArgumentException('Invalid key(s): '.implode(', ', array_keys($disallowedKeys)));
            }

            return new self(
                warehouse: $warehouse['warehouse'] ?? null,
                rack: $warehouse['rack'] ?? null,
                shelf: $warehouse['shelf'] ?? null
            );
        }

        return new self(
            warehouse: $warehouse,
            rack: $rack,
            shelf: $shelf
        );
    }

    public function __toString(): string
    {
        return $this->locationCode;
    }
}
