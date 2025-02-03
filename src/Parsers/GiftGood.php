<?php

namespace Cable8mm\GoodCode\Parsers;

use Cable8mm\GoodCode\Contracts\Parser;
use Cable8mm\GoodCode\Enums\GoodCodeType;

final class GiftGood implements Parser
{
    /**
     * {@inheritDoc}
     */
    public static function parse(string $code, ?array $goods = null): array|string
    {
        $comCode = preg_replace('/^'.GoodCodeType::GIFT->prefix().'/i', GoodCodeType::COMPLEX->prefix(), $code);

        return ComplexGood::parse($comCode, $goods);
    }
}
