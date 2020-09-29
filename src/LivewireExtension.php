<?php

namespace Enflow\LivewireTwig;

use Livewire\Livewire;

class LivewireExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('livewireStyles', [$this, 'livewireStyles'], ['is_safe' => ['html']]),
            new \Twig\TwigFunction('livewireScripts', [$this, 'livewireScripts'], ['is_safe' => ['html']]),
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
