<?php

namespace Enflow\LivewireTwig;

use Twig\Compiler;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Node;

class ThisNode extends Node
{
    // public function __construct(Node $body, int $lineno, string $tag)
    // {
    //     parent::__construct([$body], [], $lineno, $tag);
    // }

    public function compile(Compiler $compiler)
    {
        // $ext = $compiler->getEnvironment()->getExtension(LivewireExtension::class);
        $livewire = new NameExpression("__livewire", $this->lineno);
        $compiler
            ->write('$_instance = ')->subcompile($livewire)->raw(";\n")
            ->write("echo \"window.Livewire.find('{\$_instance->getId()}')\"")->raw(";\n");
            // ->write($ext->callDirective('this', []))->raw("\n");
    }
}
