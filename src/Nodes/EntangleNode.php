<?php

namespace Enflow\LivewireTwig\Nodes;

use Twig\Compiler;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;

class EntangleNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $livewire = new NameExpression('__livewire', $this->lineno);

        $compiler
            ->write('$__livewire = ')->subcompile($livewire)->raw(";\n")
            ->write('$expression = ')->subcompile($this->getNode('EntangleValue'))->raw(";\n")
            ->write("\$instance_id = \"window.Livewire.find('{\$__livewire->getId()}')\";\n")
            ->write("if ((object) (\$expression) instanceof \\Livewire\\WireDirective) echo \"\$instance_id.entangle(\$expression->value()).\$expression->hasModifier('live') ? '.live' : ''\"; else echo \"\$instance_id.entangle('\$expression')\";")->raw("\n");
    }
}
