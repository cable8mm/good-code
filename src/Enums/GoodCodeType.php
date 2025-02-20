<?php

namespace Cable8mm\GoodCode\Enums;

enum GoodCodeType
{
    case NORMAL;
    case SET;
    case COMPLEX;
    case GIFT;
    case OPTION;

    /**
     * Get prefix of GoodCodeType.
     *
     * @return string The method returns the prefix of the GoodCodeType
     *
     * @example GoodCodeType::GIFT->prefix() => 'GIF'
     */
    public function prefix(): string
    {
        return match ($this) {
            GoodCodeType::NORMAL => '',
            GoodCodeType::SET => 'SET',
            GoodCodeType::COMPLEX => 'COM',
            GoodCodeType::GIFT => 'GIF',
            GoodCodeType::OPTION => 'OPT',
        };
    }

    /**
     * Get GoodCodeType by code.
     *
     * @param  string  $code  The good code
     * @return GoodCodeType The method returns the `GoodCodeType` object
     *
     * @example GoodCodeType::of('OPT2231433') => GoodCodeType::OPTION
     */
    public static function of(string $code): GoodCodeType
    {
        $prefix = strtoupper(substr($code, 0, 3));

        return match ($prefix) {
            GoodCodeType::SET->prefix() => GoodCodeType::SET,
            GoodCodeType::COMPLEX->prefix() => GoodCodeType::COMPLEX,
            GoodCodeType::GIFT->prefix() => GoodCodeType::GIFT,
            GoodCodeType::OPTION->prefix() => GoodCodeType::OPTION,
            default => GoodCodeType::NORMAL,
        };
    }
}
