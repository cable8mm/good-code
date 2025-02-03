<?php

namespace Cable8mm\GoodCode;

use Cable8mm\GoodCode\Contracts\Parser;

/**
 * Good code can be parsed by the GoodCodeParser except option-good codes.
 */
class GoodCodeParser
{
    /** @var string Good code before parsing */
    private $parse;

    /** @var string|array Good code after parsing */
    private $parsed;

    /**
     * Constructor.
     *
     * @param  string  $parse  Good code to be parsed.
     *
     * @example (new GoodCodeParser('set7369x4ZZ4235x6'))->with(SetGood::class)->get();
     * @example (new GoodCodeParser('com2'))->with(ComplexGood::class, [1=>'set1x3ZZ43x2', 2=>...])->get();
     * @example (new GoodCodeParser('gif1'))->with(ComplexGood::class, [1=>'set1x3ZZ43x2', 2=>...])->get();
     */
    public function __construct(string $parse)
    {
        $this->parse = $parse;
    }

    /**
     * Ready to use a fit parser.
     *
     * @param  $parser  The parser eg. SetGood::class, ComplexGood::class,...
     * @param  array|null  $goods  The good codes
     */
    public function with(string $parser, ?array $goods = null): static
    {
        $this->parsed = is_null($goods) ? $parser::parse($this->parse) : $parser::parse($this->parse, $goods);

        return $this;
    }

    /**
     * Return good code or good codes.
     */
    public function get(): array|string
    {
        return $this->parsed;
    }
}
