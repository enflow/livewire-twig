<?php

namespace Enflow\LivewireTwig;

use Livewire\LivewireBladeDirectives;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

class LivewireNode extends Node
{
    public function __construct(string $component, AbstractExpression $variables, int $lineno, string $tag = null)
    {
        $nodes = ['variables' => $variables];
        parent::__construct($nodes, ['component' => $component], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $component = $this->getAttribute('component');
        $expr = $this->getNode('variables');
        $compiler
            ->write('$_instance = $context["_instance"] ?? null;', "\n")
            ->write('$_vars = ')->subcompile($expr)->raw(";\n")
            ->write("?>\n")
            ->write(LivewireBladeDirectives::livewire("'$component', \$_vars"))
            ->write("<?php\n");
    }
}
