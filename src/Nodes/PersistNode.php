<?php

namespace Enflow\LivewireTwig\Nodes;

use Enflow\LivewireTwig\LivewireExtension;
use Twig\Compiler;
use Twig\Node\Node;

class PersistNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $ext = $compiler->getEnvironment()->getExtension(LivewireExtension::class);

        $compiler
            ->write('$__name = ')->subcompile($this->attributes['name'])->raw(";\n")
            ->write($ext->callDirective('persist', ['$__name']))->raw("\n")
            ->subcompile($this->nodes[0])
            ->write($ext->callDirective('endpersist', ['$__name']))->raw("\n");
    }
}
