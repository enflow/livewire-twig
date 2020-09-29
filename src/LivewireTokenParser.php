<?php

namespace Enflow\LivewireTwig;

use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class LivewireTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): LivewireNode
    {
        $component = $this->parser->getStream()->expect(Token::NAME_TYPE)->getValue();

        $variables = null;
        if ($this->parser->getStream()->nextIf(/* Token::NAME_TYPE */ 5, 'with')) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
        }

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new LivewireNode($component, $variables, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'livewire';
    }
}
