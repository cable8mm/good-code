<?php

namespace Cable8mm\GoodCode\Parsers;

use Cable8mm\GoodCode\Contracts\Parser;
use Cable8mm\GoodCode\Enums\GoodCodeType;
use InvalidArgumentException;

final class ComplexGood implements Parser
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public static function parse(string $code, ?array $goods = null): array|string
    {
        if (is_null($goods)) {
            throw new InvalidArgumentException('$goods must be an array');
        }

        $key = preg_replace('/^'.GoodCodeType::COMPLEX->prefix().'/i', '', $code);

        return $goods[$key];
    }
}
