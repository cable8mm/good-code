<?php

namespace Cable8mm\GoodCode\Enums;

enum GoodCodeType
{
    case NORMAL;
    case SET;
    case COMPLEX;
    case GIFT;
    case OPTION;

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
