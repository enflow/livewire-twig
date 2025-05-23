<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\Facades\Blade;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LivewireExtension extends AbstractExtension
{
    public function callDirective(string $directive, array $args = []): string
    {
        $directives = Blade::getCustomDirectives();
        $call = $directives[$directive] ?? null;

        $r = call_user_func_array($call, $args);

        return "?> $r <?php\n";
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('livewireStyles', [$this, 'livewireStyles'], ['is_safe' => ['html']]),
            new TwigFunction('livewireScripts', [$this, 'livewireScripts'], ['is_safe' => ['html']]),
            new TwigFunction('livewireScriptConfig', [$this, 'livewireScriptConfig'], ['is_safe' => ['html']]),
        ];
    }

    public function livewireStyles($args = ''): string
    {
        return FrontendAssets::styles($args);
    }

    public function livewireScripts($args = ''): string
    {
        return FrontendAssets::scripts($args);
    }

    public function livewireScriptConfig($args = []): string
    {
        return FrontendAssets::scriptConfig($args);
    }

    public function getTokenParsers(): array
    {
        return [
            new LivewireTokenParser,
        ];
    }
}
