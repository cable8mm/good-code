<?php

namespace Cable8mm\GoodCode;

use BadFunctionCallException;
use Cable8mm\GoodCode\Enums\GoodCodeType;
use Cable8mm\GoodCode\ValueObjects\SetGood;

/**
 * This class makes a set code, option code and so on.
 *
 * @author Samgu Lee <cable8mm@gmail.com>
 *
 * @since  2025-02-04
 */
class GoodCode
{
    /**
     * The type of the code
     */
    private GoodCodeType $type;

    /**
     * Constructor.
     *
     * @param  string  $code  The code
     * @param  \Cable8mm\GoodCode\Enums\GoodCodeType  $originType  The type of the code
     */
    public function __construct(
        private string $code,
        private GoodCodeType $originType,
    ) {
        $this->type = GoodCodeType::of($code);
    }

    /**
     * Gets the `code` property
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * Gets the `originalType` property
     */
    public function originalType(): GoodCodeType
    {
        return $this->originType;
    }

    /**
     * Gets the `type` property
     */
    public function type(): GoodCodeType
    {
        return $this->type;
    }

    /**
     * Output value for good code.
     * If the code is set code, it will be array of good values.
     * If the code is normal code, it will be good code string.
     * the code shouldn't be option, complex and gift code.
     *
     * @throws BadFunctionCallException
     */
    public function value(): int|string|array
    {
        if ($this->type == GoodCodeType::OPTION || $this->type == GoodCodeType::GIFT || $this->type == GoodCodeType::COMPLEX) {
            return throw new BadFunctionCallException('Only complex and set code types are supported');
        }

        if ($this->type == GoodCodeType::SET) {
            return SetGood::of($this->code)->goods();
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
     * @param  array<string,int>  $setCodes  key-value set code array
     * @return GoodCode The method returns GoodCode instance with the SetCode array
     *
     * @example GoodCode::setCodeOf(['7369'=>4,'4235'=>6])
     */
    public static function setCodeOf(array $setCodes): GoodCode
    {
        return new GoodCode(
            SetGood::ofArray($setCodes)->code(),
            GoodCodeType::SET
        );
    }
}
