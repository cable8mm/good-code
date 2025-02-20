<?php

namespace Cable8mm\GoodCode\ValueObjects;

use Cable8mm\GoodCode\Enums\GoodCodeType;
use InvalidArgumentException;
use Stringable;

class SetGood implements Stringable
{
    /**
     * The delimiter for multiple good code
     */
    const DELIMITER = 'zz';

    /**
     * The delimiter for good count
     */
    const DELIMITER_COUNT = 'x';

    /**
     * @var array<string,string> array of good code and count
     */
    private array $goods;

    /**
     * Constructor.
     *
     * @param  string  $code  The name of the good code
     */
    private function __construct(private readonly string $code)
    {
        $this->pipe();
    }

    /**
     * Find set-good code by parsing. A set of good code aka set-code is a combination of two more goods codes.
     *
     * @param  string  $setCode  "set1232x3ZZ322ZZ4313x4" means "1232" x 3 + "322" x 4 + "4313" x 4. "1232", "322" and "4312" are good codes.
     * @return array The method returns good code array
     */
    private function pipe(): void
    {
        $payload = preg_replace('/^'.GoodCodeType::SET->prefix().'/i', '', $this->code);

        foreach (explode(SetGood::DELIMITER, $payload) as $good) {
            [$k, $v] = explode(SetGood::DELIMITER_COUNT, $good);
            $this->goods[$k] = $v;
        }
    }

    /**
     * Create SetGood instance from code.
     *
     * @param  string  $code  The set code string
     * @return SetGood The method returns SetGood instance with the SetCode string
     */
    public static function of(string $code): SetGood
    {
        if (! preg_match('/^'.GoodCodeType::SET->prefix().'/i', $code)) {
            throw new InvalidArgumentException('It is not valid code');
        }

        return new self($code);
    }

    /**
     * Create SetGood instance from key-value set code array.
     *
     * @param  array<string,int>  $setCodes  key-value set code array
     * @return SetGood The method returns SetGood instance with the SetCode string
     *
     * @example SetGood::ofArray(['7369'=>4,'4235'=>6]) => SET7369x4zz42335x6
     */
    public static function ofArray(array $setCodes): SetGood
    {
        $code = GoodCodeType::SET->prefix().implode(SetGood::DELIMITER, array_map(function ($v, $k) {
            return $k.SetGood::DELIMITER_COUNT.$v;
        }, $setCodes, array_keys($setCodes)));

        return static::of($code);
    }

    /**
     * Gets a `code` property.
     *
     * @return string The method returns `code` property
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * Gets a `goods` property.
     *
     * @return array The method returns `goods` property
     */
    public function goods(): array
    {
        return $this->goods;
    }

    /**
     * Gets a string representation of the object.
     */
    public function __toString(): string
    {
        return $this->code;
    }
}
