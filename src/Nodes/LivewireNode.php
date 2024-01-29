<?php

namespace Enflow\LivewireTwig\Nodes;

use Enflow\LivewireTwig\LivewireExtension;
use Twig\Compiler;
use Twig\Node\Node;

class LivewireNode extends Node
{
    public function __construct(Node $component, array $attributes, int $lineno, ?string $tag = null)
    {
        $nodes = ['variables' => $attributes['variables'], 'key' => $attributes['key']];
        parent::__construct($nodes, ['component' => $component], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $ext = $compiler->getEnvironment()->getExtension(LivewireExtension::class);

        $component = $this->getAttribute('component');
        $expr = $this->getNode('variables');
        $key = $this->getNode('key');
        $hasKey = ! $key->hasAttribute('value') || $key->getAttribute('value') !== '';

        $compiler
            ->write('$_name = ')->subcompile($component)->raw(";\n")
            ->write('$_vars = ')->subcompile($expr)->raw(";\n");

        if ($hasKey) {
            $compiler
                ->write('$_key = ')->subcompile($key)->raw(";\n")
                ->write($ext->callDirective('livewire', ['$_name, $_vars, key($_key)']));
        } else {
            $compiler
                ->write($ext->callDirective('livewire', ['$_name, $_vars']));
        }
    }
}
