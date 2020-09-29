<?php

namespace Enflow\LivewireTwig\Test;

use Livewire\Component;
use Livewire\Livewire;

class CounterTest extends TestCase
{
    public function test_is_renders_the_counter()
    {
        Livewire::component('counter', Counter::class);

        $rendered = view('layout')->render();

        $this->assertStringContainsString('[wire\:loading]', $rendered); // Styles
        $this->assertStringContainsString('window.livewire', $rendered); // Scripts
        $this->assertStringContainsString('increment', $rendered); // Counter component
        $this->assertStringContainsString('Lorem ipsum!', $rendered); // Counter component title
    }
}

class Counter extends Component
{
    public $count = 3;
    public $title = null;

    public function render()
    {
        return view('counter');
    }
}
