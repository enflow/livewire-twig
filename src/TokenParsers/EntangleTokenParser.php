<?php

namespace Enflow\LivewireTwig\TokenParsers;

use Enflow\LivewireTwig\Nodes\EntangleNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class EntangleTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): EntangleNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $entVar = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Token::BLOCK_END_TYPE);

        return new EntangleNode(['EntangleValue' => $entVar], [], $lineno, $this->getTag());
    }

    public function getTag(): string
    {
        return 'entangle';
    }
}
