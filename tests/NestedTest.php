<?php

namespace Enflow\LivewireTwig\Test;

use Livewire\Component;
use Livewire\Livewire;

class NestedTest extends TestCase
{
    public function test_nested_component_renders_only_once()
    {
        Livewire::component('childcounter', Child::class);

        $nested = Livewire::test(NestedChilds::class);
        $nested->assertSeeLivewire('childcounter');
        $nested->call('increment');   // should not call render() in Child, renderedCound should remain 1
        $this->assertLessThan(2, Child::$renderedCount, 'Child component rendered more than once');
    }
}

class NestedChilds extends Component
{
    public $elements;

    public $counter = 0;

    public function increment()
    {
        $this->counter++;
    }

    public function render()
    {
        return view('components.haschilds');
    }
}

class Child extends Component
{
    public static $renderedCount = 0;

    public $count = 1;

    public function incrementChild()
    {
        $this->count++;
    }

    public function render()
    {
        static::$renderedCount++;
        $this->count = static::$renderedCount;

        return view('components.counter');
    }
}
