<?php

namespace Cable8mm\GoodCodeParser;

use Cable8mm\GoodCodeParser\Parsers\SetGood;

/**
 * Make set code, option code and so on.
 */
class GoodCode
{
    /**
     * Make SetCode from key-value set code array.
     *
     * @param  array  $setCodes  key-value set code array
     * @return string The method returns the SetCode
     *
     * @example GoodCode::makeSetCode(['7369'=>4,'4235'=>6]) set7369x4ZZ4235x6
     */
    public static function makeSetCode(array $setCodes): string
    {
        return SetGood::PREFIX.implode(SetGood::DELIMITER, array_map(function ($v, $k) {
            return $k.SetGood::DELIMITER_COUNT.$v;
        }, $setCodes, array_keys($setCodes)));
    }

    /**
     * Make set code key-value array from SetCode.
     *
     * @param  string  $setCode  SetCode
     * @return array key-value set code
     *
     * @example GoodCode::setCodes('set7369x4ZZ4235x6)  ['7369'=>4,'4235'=>6]
     */
    public static function getSetCodes(string $setCode): array
    {
        return (new GoodCodeParser($setCode))
            ->with(SetGood::class)
            ->get();
    }

    /**
     * Get ID from GIF and COM codes.
     *
     * @param  string  $code  GIF or COM code
     * @return int The method returns ID
     */
    public static function getId(string $code): int
    {
        return (int) preg_replace('/[^0-9]/', '', $code);
    }
}
