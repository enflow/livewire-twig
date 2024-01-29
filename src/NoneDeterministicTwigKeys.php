<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\Str;
use Livewire\Mechanisms\ExtendBlade\DeterministicBladeKeys;

class NoneDeterministicTwigKeys extends DeterministicBladeKeys
{
    public function generate(): string
    {
        // We don't need to generate a deterministic key for Twig. livewire/livewire uses some Blade magic to generate fixed keys.
        // @TODO: we could technically use the same logic here.
        // See https://github.com/livewire/livewire/pull/7751/files
        return Str::random(7);
    }
}
