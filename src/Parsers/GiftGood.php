<?php

namespace EscCompany\GoodCodeParser\Parsers;

use EscCompany\GoodCodeParser\Contracts\Parser;
use EscCompany\GoodCodeParser\Exception\MethodNotImplementedException;

final class GiftGood implements Parser
{
    /**
     * {@inheritDoc}
     */
    public function parse(string $code)
    {
        throw new MethodNotImplementedException(__METHOD__);
    }
}
