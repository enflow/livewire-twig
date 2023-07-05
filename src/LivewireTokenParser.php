<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\Str;
use Twig\Error\SyntaxError;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use Twig\Node\Expression\ArrayExpression;

class LivewireTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): LivewireNode
    {
        $componentNameToken = $this->parser->getStream()->next();

        if ($componentNameToken->test(Token::NAME_TYPE) || $componentNameToken->test(Token::STRING_TYPE)) {
            $component = $componentNameToken->getValue();
        } else {
            throw new SyntaxError(
                sprintf(
                    'Unexpected token "%s"%s ("%s" or "%s" expected).',
                    Token::typeToEnglish($componentNameToken->getType()),
                    $componentNameToken->getValue() ? sprintf(' of value "%s"', $componentNameToken->getValue()) : '',
                    Token::typeToEnglish(Token::NAME_TYPE),
                    Token::typeToEnglish(Token::STRING_TYPE)
                ),
                $componentNameToken->getLine(),
                $this->parser->getStream()->getSourceContext()
            );
        }

        if ($this->parser->getStream()->nextIf(/* Token::NAME_TYPE */ 5, 'with')) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $variables = new ArrayExpression([], $token->getLine());
        }

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new LivewireNode(Str::kebab($component), $variables, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'livewire';
    }
}
