<?php

namespace Enflow\LivewireTwig;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class LivewireTwigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->afterResolving('twig', fn () => $this->app['twig']->addExtension(new LivewireExtension()));
    }
}
