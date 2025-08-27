<?php

namespace Enflow\LivewireTwig;

use Enflow\LivewireTwig\Nodes\EntangleNode;
use Enflow\LivewireTwig\Nodes\LivewireNode;
use Enflow\LivewireTwig\Nodes\PersistNode;
use Enflow\LivewireTwig\Nodes\ThisNode;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class LivewireTokenParser extends AbstractTokenParser
{
    protected array $types = [
        'this',
        'entangle',
        'persist',
        'endpersist',
        'component',
    ];

    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        // Expect the '.' after `livewire`. Twig 3.21.0 changes from PUNCTUATION_TYPE to OPERATOR_TYPE for '.'
        $stream->expect(Token::OPERATOR_TYPE, '.');

        // Detect the type after the dot
        $type = $stream->expect(Token::NAME_TYPE)->getValue();

        // Go into the type specific logic
        return (match ($type) {
            'this' => function () use ($stream, $lineno) {
                $stream->expect(Token::BLOCK_END_TYPE); // Expect the end block

                return new ThisNode([], [], $lineno, $this->getTag());
            },

            'entangle' => function () use ($stream, $lineno) {
                $entVar = $this->parser->getExpressionParser()->parseExpression();
                $stream->expect(Token::BLOCK_END_TYPE);

                return new EntangleNode(['EntangleValue' => $entVar], [], $lineno, $this->getTag());
            },

            'persist' => function () use ($stream, $lineno) {
                // Parse the name.
                $name = $this->parser->getExpressionParser()->parseExpression();

                // Expect the end block for the start tag.
                $stream->expect(Token::BLOCK_END_TYPE);

                // Parse the body until the 'endpersist' tag.
                $body = $this->parser->subparse(fn (Token $token) => $token->test('livewire'), true);

                // Now, since we know we're at a 'livewire.' token, we should expect the 'endpersist' after it.
                $stream->expect(Token::PUNCTUATION_TYPE, '.');

                // Now, we should expect the 'endpersist' name.
                $stream->expect(Token::NAME_TYPE, 'endpersist');

                // We can expect the closing block now: `%}`
                $stream->expect(Token::BLOCK_END_TYPE);

                return new PersistNode([$body], ['name' => $name], $lineno, $this->getTag());
            },

            'component' => function () use ($stream, $lineno) {
                // Proceed with parsing the livewire.component
                $component = $this->parser->getExpressionParser()->parseExpression();

                $variables = new ArrayExpression([], $lineno);
                $key = new ConstantExpression('', $lineno);

                while (! $stream->test(Token::BLOCK_END_TYPE)) {
                    if ($stream->test(Token::NAME_TYPE, 'with')) {
                        $stream->next();  // Consume the 'with' token
                        $variables = $this->parser->getExpressionParser()->parseExpression();
                    } elseif ($stream->test(Token::NAME_TYPE, 'key')) {
                        $stream->next();  // Consume the 'key' token
                        $stream->expect(Token::PUNCTUATION_TYPE, '(');
                        $key = $this->parser->getExpressionParser()->parseExpression();
                        $stream->expect(Token::PUNCTUATION_TYPE, ')');
                    } else {
                        throw new SyntaxError(sprintf('Unexpected token in livewire tag. Twig was expecting the end of the directive starting at line %d).', $lineno), $lineno, $stream->getSourceContext());
                    }
                }

                $stream->expect(Token::BLOCK_END_TYPE); // Expect the end block

                $attrs = ['variables' => $variables, 'key' => $key];

                return new LivewireNode($component, $attrs, $lineno, $this->getTag());
            },

            default => fn () => throw new SyntaxError(sprintf('Unexpected token after "livewire.". Expected %s but got "%s".', implode(' or ', $this->types), $type), $lineno, $stream->getSourceContext()),
        })();
    }

    public function getTag(): string
    {
        return 'livewire';
    }
}
