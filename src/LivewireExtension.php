<?php

namespace Enflow\LivewireTwig;

use Livewire\Livewire;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LivewireExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('livewireStyles', [$this, 'livewireStyles'], ['is_safe' => ['html']]),
            new TwigFunction('livewireScripts', [$this, 'livewireScripts'], ['is_safe' => ['html']]),
        ];
    }

    public function livewireStyles()
    {
        return Livewire::styles();
    }

    public function livewireScripts()
    {
        return Livewire::scripts();
    }

    public function getTokenParsers()
    {
        return [
            new LivewireTokenParser(),
        ];
    }
}
