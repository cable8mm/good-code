<?php

namespace Cable8mm\GoodCode\Contracts;

/**
 * Parser interface.
 *
 * Various Good must be implemented. This method is called when the parser recognizes something like 'gift' or 'opt'.
 */
interface Parser
{
    /**
     * Find good code by parsing.
     *
     * @param  string  $goodCode  before parsing
     * @return array|string Good code
     *
     * @throws InvalidArgumentException
     */
    public static function parse(string $parse, ?array $goods = null): array|string;
}
