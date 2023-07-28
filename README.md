# Livewire for Twig

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)
![GitHub Workflow Status](https://github.com/enflow/livewire-twig/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)

The `enflow/livewire-twig` package provides the option to load Livewire components in your Twig templates.

## Update notes
This version supports Livewire 3. 
The name argument for {% livewire %} and the other directives is now interpreted as an expression, allowing the use of variables or Twig expressions as a name. Note that for this reason a constant name now must be enclosed in quotes.

## Installation
You can install the package via composer:

``` bash
composer require enflow/livewire-twig
```

## Usage
The Twig extension will automatically register when `rcrowe/twigbridge` is used.
If you're using another configuration, you may wish to register the extension manually by loading the extension `Enflow\LivewireTwig\LivewireExtension`.

This package provides wrappers for the `@livewireScripts`, `@livewireStyles`, `@livewireScriptConfig`, `@livewire`, `@entangle`, `@this` and `@persist`,  directives. Everything else under the hood is powered by `livewire/livewire`.   
You can register your Livewire components like normal. 

To use Livewire, add the following tags in the `head` tag, and before the end `body` tag in your template.

```twig
<html>
<head>
    ...
    {{ livewireStyles() }}
</head>
<body>
    ...
    {{ livewireScripts() }}
</body>
</html>
```

In your body you may include the component like:

```twig
{# The Twig version of '@livewire' #}
{% livewire 'counter' %}

{# If you wish to pass along variables to your component #}
{% livewire 'counter' with {'count': 3} %}

{# To include a nested component (or dashes), you need to use '' #}
{% livewire 'nested.component' %}

{# To use key tracking, you need to use key(<expression>) #}
{% livewire 'counter' key('counterkey') %}

{# The Twig version of '@persist' #}
{% persist 'name' %}
<div>
    ...
</div>
{% endpersist %}

{# The Twig version of '@entangle' (as of Livewire 3.01 poorly documented, need to check the source code) #}
{% entangle 'expression' %}

{# The Twig version of '@this' (Can only be used after Livewire initialization is complete) #}
{% this %}

{# The Twig version of '@livewireScriptConfig' (as of Livewire 3.01 poorly documented, need to check the source code) #}
{{ livewireScriptConfig(<options>) }}
```

### Example

Add the following to `resources/views/livewire/counter.twig`
```twig
<div>
    <div wire:click="add">+</div>
    <div>{{ count }}</div>
    <div wire:click="subtract">-</div>
</div>
```

Add the following to `app/Http/Livewire/Counter.php`
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 1;

    public function add()
    {
        $this->count++;
    }

    public function subtract()
    {
        $this->count--;
    }
}
```

## Todo
- [ ] Moar tests.

## Testing
``` bash
$ composer test
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email michel@enflow.nl instead of using the issue tracker.

## Credits
- [Michel Bardelmeijer](https://github.com/mbardelmeijer)
- [All Contributors](../../contributors)

## About Enflow
Enflow is a digital creative agency based in Alphen aan den Rijn, Netherlands. We specialize in developing web applications, mobile applications and websites. You can find more info [on our website](https://enflow.nl/en).

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
