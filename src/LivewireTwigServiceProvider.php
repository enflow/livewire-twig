<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\ServiceProvider;
use Livewire\Mechanisms\ExtendBlade\DeterministicBladeKeys;

class LivewireTwigServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->afterResolving('twig', fn () => $this->app['twig']->addExtension(new LivewireExtension()));

        $this->app->extend(DeterministicBladeKeys::class, fn () => new NoneDeterministicTwigKeys());
    }
}
