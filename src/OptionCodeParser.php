<?php

namespace Cable8mm\GoodCode;

/**
 * Option-good code can be parsed by the OptionGoodCodeParser.
 *
 * Option-good code can be matched by 'name', because option-good code have not code, so GoodCodeParser can not be used to parse option-good codes.
 */
class OptionCodeParser
{
    /**
     * @var string Good code before parsing
     */
    private $parse;

    /**
     * @var string Good name before parsing
     */
    private $name;

    /**
     * @var string|array Good code after parsing
     */
    private $parsed;

    /**
     * Constructor.
     *
     * @param  string  $parse  Good name to be parsed.
     * @param  string  $name  Option good name to be parsed.
     */
    public function __construct(string $parse, string $name)
    {
        $this->parse = $parse;
        $this->name = $name;
    }

    /**
     * Ready to use a fit parser.
     *
     * @param  string  $parser  Parser name eg. OptionGood::class.
     * @param  array  $goods  Good code array
     * @param  array  $options  Option code array
     */
    public function with(string $parser, array $goods, array $options): static
    {
        $this->parsed = $parser::parse($this->parse, $this->name, $goods, $options);

        return $this;
    }

    /**
     * Return option-good code or codes.
     */
    public function get(): array|string
    {
        return $this->parsed;
    }
}
