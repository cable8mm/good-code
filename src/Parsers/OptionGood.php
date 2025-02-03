<?php

namespace Cable8mm\GoodCodeParser\Parsers;

use Cable8mm\GoodCodeParser\Contracts\OptionParser;
use InvalidArgumentException;

final class OptionGood implements OptionParser
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public static function parse(string $code, string $name, array $goods, array $options): array|string
    {
        $optionGood = null;

        foreach ($goods as $good) {
            if ($code == $good['code']) {
                $optionGood = $good;
            }
        }

        if (empty($optionGood)) {
            throw new InvalidArgumentException(__METHOD__.' There is no good code');
        }

        foreach ($options as $option) {
            if ($option['code'] == $optionGood['id'] && $option['name'] == $name) {
                return $option['master_code'];
            }
        }

        if (is_null($optionGood)) {
            throw new InvalidArgumentException(__METHOD__.' There is no option good code');
        }
    }
}
