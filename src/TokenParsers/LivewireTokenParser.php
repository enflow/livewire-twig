<?php

namespace Enflow\LivewireTwig\TokenParsers;

use Enflow\LivewireTwig\Nodes\LivewireNode;
use Illuminate\Support\Str;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class LivewireTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): LivewireNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $component = $this->parser->getExpressionParser()->parseExpression();

        $end = false;
        $variables = new ArrayExpression([], $token->getLine());
        $key = new ConstantExpression('', $lineno);
        while (! $end) {
            $n = $stream->next();
            if ($n->test(Token::NAME_TYPE, 'with')) {
                $variables = $this->parser->getExpressionParser()->parseExpression();
            } elseif ($n->test(Token::NAME_TYPE, 'key')) {
                $this->parser->getStream()->expect(Token::PUNCTUATION_TYPE, '(');
                $key = $this->parser->getExpressionParser()->parseExpression();
                $this->parser->getStream()->expect(Token::PUNCTUATION_TYPE, ')');
            } elseif ($n->test(Token::BLOCK_END_TYPE)) {
                $end = true;
            } else {
                throw new SyntaxError(sprintf('Unexpected end of template. Twig was expecting the end of the directive starting at line %d).', $lineno), $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
        }

        $attrs = ['variables' => $variables, 'key' => $key];
        return new LivewireNode($component, $attrs, $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'livewire';
    }
}
