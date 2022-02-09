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
        $this->assertStringContainsString('window.livewire', $rendered); // Scripts
        $this->assertStringContainsString('increment', $rendered); // Counter component
        $this->assertStringContainsString('Lorem ipsum!', $rendered); // Counter component title
    }

    public function test_string_type_component_correctly_renders()
    {
        Livewire::component('counter', Counter::class);

        $rendered = view('string-type-test')->render();

        $this->assertStringContainsString('[wire\:loading]', $rendered); // Styles
        $this->assertStringContainsString('window.livewire', $rendered); // Scripts
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

    public function test_invalid_type_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unexpected token "number" of value "63" ("name" or "string" expected).');
        Livewire::component('counter', Counter::class);

        $rendered = view('invalid-type-test')->render();
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
