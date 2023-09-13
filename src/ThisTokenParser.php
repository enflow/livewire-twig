<?php

namespace Enflow\LivewireTwig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class ThisTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): ThisNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $stream->expect(Token::BLOCK_END_TYPE);

        return new ThisNode([], [], $lineno, $this->getTag());
    }

    public function getTag(): string
    {
        return 'this';
    }
}
