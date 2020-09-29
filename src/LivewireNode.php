<?php

namespace Enflow\LivewireTwig;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

class LivewireNode extends Node
{
    public function __construct(string $component, ?AbstractExpression $variables, int $lineno, string $tag = null)
    {
        $nodes = [];
        if (null !== $variables) {
            $nodes['variables'] = $variables;
        }

        parent::__construct($nodes, ['component' => $component], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $component = $this->getAttribute('component');

        $compiler->raw("if (! isset(\$_instance)) {")
            ->outdent()
            ->raw("\$html = \Livewire\Livewire::mount('$component', ");

        if (! $this->hasNode('variables')) {
            $compiler->raw('[]');
        } else {
            $compiler->raw('twig_to_array(');
            $compiler->subcompile($this->getNode('variables'));
            $compiler->raw(')');
        }

        $compiler->raw(")->html();\n")
            ->indent()
            ->raw("}");

        $compiler->write("echo \$html;");
    }
}
