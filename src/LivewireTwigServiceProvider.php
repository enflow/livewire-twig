<?php

namespace Enflow\LivewireTwig;

use Illuminate\Support\ServiceProvider;

class LivewireTwigServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->afterResolving('twig', fn () => $this->app['twig']->addExtension(new LivewireExtension()));
    }
}
