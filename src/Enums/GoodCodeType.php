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
            GoodCodeType::SET => 'set',
            GoodCodeType::COMPLEX => 'com',
            GoodCodeType::GIFT => 'gif',
            GoodCodeType::OPTION => 'opt',
        };
    }

    public static function of(string $code): GoodCodeType
    {
        $prefix = substr($code, 0, 3);

        return match ($prefix) {
            GoodCodeType::SET->prefix() => GoodCodeType::SET,
            GoodCodeType::COMPLEX->prefix() => GoodCodeType::COMPLEX,
            GoodCodeType::GIFT->prefix() => GoodCodeType::GIFT,
            GoodCodeType::OPTION->prefix() => GoodCodeType::OPTION,
            default => GoodCodeType::NORMAL,
        };
    }
}
