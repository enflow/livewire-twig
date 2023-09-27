<?php

namespace Enflow\LivewireTwig\Test;

use Livewire\Component;
use Livewire\Livewire;

class RenderTest extends TestCase
{
    public function test_name_type_component_correctly_renders()
    {
        Livewire::component('counter', Counter::class);

        $rendered = view('name-type-test')->render();

        $this->assertStringContainsString('[wire\:loading]', $rendered); // Styles
        $this->assertStringContainsString('script src="/livewire/livewire.js', $rendered); // Scripts
        $this->assertStringContainsString('increment', $rendered); // Counter component
        $this->assertStringContainsString('Lorem ipsum!', $rendered); // Counter component title
    }

    public function test_string_type_component_correctly_renders()
    {
        Livewire::component('counter', Counter::class);

        $rendered = view('string-type-test')->render();

        $this->assertStringContainsString('[wire\:loading]', $rendered); // Styles
        $this->assertStringContainsString('script src="/livewire/livewire.js', $rendered); // Scripts
        $this->assertStringContainsString('increment', $rendered); // Counter component
        $this->assertStringContainsString('Lorem ipsum!', $rendered); // Counter component title
    }

    public function test_nested_component_correctly_renders()
    {
        Livewire::component('table', Table::class);
        Livewire::component('table.row', TableRow::class);
        Livewire::component('dashed-counter', Counter::class);

        $rendered = view('nested-test')->render();

        $this->assertStringContainsString('increment', $rendered);
        $this->assertStringContainsString('Foo', $rendered);
        $this->assertStringContainsString('Bar', $rendered);
    }

    public function test_unknown_component_throws_exception()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Unable to find component: [63]');
        Livewire::component('counter', Counter::class);

        $rendered = view('unknown-component-test')->render();
    }

    public function test_entangle()
    {
        Livewire::component('entangle', Entangle::class);

        $rendered = view('entangle-test')->render();
        $this->assertStringContainsString('entangle(\'entangled\')', $rendered);
    }

    public function test_this()
    {
        Livewire::component('this', This::class);

        $rendered = view('this-test')->render();
        $this->assertStringContainsString('window.Livewire.find(\'', $rendered);
    }

    public function test_persist()
    {
        Livewire::component('persist', Persist::class);

        $rendered = view('persist-test')->render();
        $this->assertStringContainsString('x-persist=', $rendered);
    }

    public function test_config()
    {
        Livewire::component('this', This::class);

        $rendered = view('this-test')->render();
        $this->assertStringContainsString('window.livewireScriptConfig', $rendered);
    }
}

class Counter extends Component
{
    public $count = 3;

    public $title = null;

    public function render()
    {
        return view('components.counter');
    }
}

class Table extends Component
{
    public $elements;

    public function render()
    {
        return view('components.table');
    }
}

class TableRow extends Component
{
    public $element;

    public function render()
    {
        return view('components.table.row');
    }
}

class This extends Component
{
    public function render()
    {
        return view('components.this');
    }
}

class Entangle extends Component
{
    public $entangle = 1;

    public function render()
    {
        return view('components.entangle');
    }
}

class Persist extends Component
{
    public function render()
    {
        return view('components.persist');
    }
}
