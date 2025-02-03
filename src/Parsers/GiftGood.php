<?php

namespace Cable8mm\GoodCodeParser\Parsers;

use Cable8mm\GoodCodeParser\Contracts\Parser;
use Cable8mm\GoodCodeParser\Enums\GoodCodeType;

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
