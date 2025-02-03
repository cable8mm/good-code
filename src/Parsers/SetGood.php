<?php

namespace Cable8mm\GoodCodeParser\Parsers;

use Cable8mm\GoodCodeParser\Contracts\Parser;
use Cable8mm\GoodCodeParser\Enums\GoodCodeType;
use InvalidArgumentException;

final class SetGood implements Parser
{
    const DELIMITER = 'ZZ';

    const DELIMITER_COUNT = 'x';

    /**
     * Find set-good code by parsing. A set of good code aka set-code is a combination of two more goods codes.
     *
     * @param  string  $goodCode  "set1232x3ZZ322ZZ4313x4" means "1232" x 3 + "322" x 4 + "4313" x 4. "1232", "322" and "4312" are good codes.
     * @param  string  $goods  NEVER used.
     * @return array|string Good code
     *
     * @throws InvalidArgumentException
     */
    public static function parse(string $parse, $goods = null): array|string
    {
        if (! is_null($goods)) {
            throw new InvalidArgumentException('$goods is never used.');
        }

        $escape = preg_replace('/^'.GoodCodeType::SET->prefix().'/i', '', $parse);

        $goodCodes = explode(self::DELIMITER, $escape);

        $parsedCodes = [];

        foreach ($goodCodes as $code) {
            if (preg_match('/'.self::DELIMITER_COUNT.'/i', $code)) {
                [$k, $v] = explode(self::DELIMITER_COUNT, $code);
            } else {
                [$k, $v] = [$code, 1];
            }
            $parsedCodes[$k] = $v;
        }

        return $parsedCodes;
    }
}
