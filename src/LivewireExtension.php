<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;

class LivewireExtension extends AbstractExtension
{
    protected Collection $calls;
    protected array $dirs = [
        'livewireScripts',
        'livewireScriptConfig',
        'livewireStyles',
        'this',
        'livewire',
        'persist',
        'endpersist',
        'entangle'
    ];

    public function __construct()
    {
        $customDirectives = Blade::getCustomDirectives();

        $this->calls = collect($this->dirs)->mapWithKeys(fn($e) => [$e => $customDirectives[$e]]);
    }

    public function callDirective(string $directive, array $args = []): string
    {
        $call = $this->calls[$directive];
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
            new LivewireTokenParser(),
            new PersistTokenParser(),
            new ThisTokenParser(),
            new EntangleTokenParser()
        ];
    }
}
