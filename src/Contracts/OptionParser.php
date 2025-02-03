<?php

namespace Cable8mm\GoodCode\Contracts;

/**
 * OptionParser interface. Option Good must be implemented. This method is called when the parser recognizes option good.
 */
interface OptionParser
{
    /**
     * Find option-good code by parsing. Option-good can be matched by 'name', because option-good have not code.
     *
     * @param  string  $code  good code.
     * @param  string  $name  good name.
     * @param  array  $goods  option-goods
     * @param  array  $options  option-good-options
     * @return string|void Good code
     */
    public static function parse(string $code, string $name, array $goods, array $options);
}
