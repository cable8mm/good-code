<?php

namespace Cable8mm\GoodCode;

use BadFunctionCallException;
use Cable8mm\GoodCode\Enums\GoodCodeType;
use InvalidArgumentException;

/**
 * Make set code, option code and so on.
 */
class GoodCode
{
    const SET_CODE_DELIMITER = 'zz';

    const SET_CODE_DELIMITER_COUNT = 'x';

    private GoodCodeType $type;

    public function __construct(
        private string $code,
        private GoodCodeType $originType,
    ) {
        $this->type = GoodCodeType::of($code);
    }

    public function code(): string
    {
        return $this->code;
    }

    public function originalType(): GoodCodeType
    {
        return $this->originType;
    }

    public function type(): GoodCodeType
    {
        return $this->type;
    }

    /**
     * Output value for good code.
     * If the code is set code, it will be array of good values.
     * If the code is normal code, it will be good code string.
     * the code shouldn't be option, complex and gift code.
     */
    public function value(): int|string|array
    {
        if ($this->type == GoodCodeType::OPTION || $this->type == GoodCodeType::GIFT || $this->type == GoodCodeType::COMPLEX) {
            return throw new BadFunctionCallException('Only complex and set code types are supported');
        }

        if ($this->type == GoodCodeType::SET) {
            return self::getSetCodes($this->code);
        }

        return $this->code;
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

    /**
     * Create GoodCode instance from given code string and callback function
     *
     * @param  string  $code  `good_code`, `set_code`, `option_code`
     * @param  ?callable  $callback  Function to call
     * @param  ?string  $option  `option_good_option` name
     * @return GoodCode The method returns GoodCode instance.
     */
    public static function of(string $code, ?string $option = null, ?callable $callback = null): GoodCode
    {
        $type = $originalType = GoodCodeType::of($code);

        if ($type == GoodCodeType::OPTION) {
            $code = $callback(self::getId($code), $option);
            $type = GoodCodeType::of($code);
        }

        if ($type == GoodCodeType::COMPLEX || $type == GoodCodeType::GIFT) {
            $code = $callback(self::getId($code));
        }

        return new GoodCode($code, $originalType);
    }

    /**
     * Make SetCode from key-value set code array.
     *
     * @param  array  $setCodes  key-value set code array
     * @return GoodCode The method returns GoodCode instance with the SetCode array
     *
     * @example GoodCode::setCodeOf(['7369'=>4,'4235'=>6])
     */
    public static function setCodeOf(array $setCodes): GoodCode
    {
        return new GoodCode(
            self::makeSetCode($setCodes),
            GoodCodeType::SET
        );
    }

    /**
     * Make SetCode from key-value set code array.
     *
     * @param  array  $setCodes  key-value set code array
     * @return string The method returns GoodCode instance with the SetCode string
     *
     * @example GoodCode::setCodeOf(['7369'=>4,'4235'=>6])
     */
    private static function makeSetCode(array $setCodes): string
    {
        return GoodCodeType::SET->prefix().implode(self::SET_CODE_DELIMITER, array_map(function ($v, $k) {
            return $k.self::SET_CODE_DELIMITER_COUNT.$v;
        }, $setCodes, array_keys($setCodes)));
    }

    /**
     * Find set-good code by parsing. A set of good code aka set-code is a combination of two more goods codes.
     *
     * @param  string  $setCode  "set1232x3ZZ322ZZ4313x4" means "1232" x 3 + "322" x 4 + "4313" x 4. "1232", "322" and "4312" are good codes.
     * @return array The method returns good code array
     *
     * @throws InvalidArgumentException
     */
    public static function getSetCodes(string $setCode): array
    {
        $escape = preg_replace('/^'.GoodCodeType::SET->prefix().'/i', '', $setCode);

        $goodCodes = explode(self::SET_CODE_DELIMITER, $escape);

        $parsedCodes = [];

        foreach ($goodCodes as $code) {
            if (preg_match('/'.self::SET_CODE_DELIMITER_COUNT.'/i', $code)) {
                [$k, $v] = explode(self::SET_CODE_DELIMITER_COUNT, $code);
            } else {
                [$k, $v] = [$code, 1];
            }
            $parsedCodes[$k] = $v;
        }

        return $parsedCodes;
    }
}
