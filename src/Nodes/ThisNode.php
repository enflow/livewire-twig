<?php

namespace Enflow\LivewireTwig\Nodes;

use Twig\Compiler;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;

class ThisNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $livewire = new NameExpression('__livewire', $this->lineno);

        $compiler
            ->write('$_instance = ')->subcompile($livewire)->raw(";\n")
            ->write("echo \"window.Livewire.find('{\$_instance->getId()}')\"")->raw(";\n");
    }
}
