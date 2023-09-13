<?php

namespace Enflow\LivewireTwig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class PersistTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): PersistNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression(); //$stream->next();
        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'endPersist']);
        $stream->next();
        $stream->expect(Token::BLOCK_END_TYPE);

        return new PersistNode([$body], ['name' => $name], $lineno, $this->getTag());
    }

    public function endPersist(Token $token): bool
    {
        return $token->test(['endpersist']);
    }

    public function getTag(): string
    {
        return 'persist';
    }
}
