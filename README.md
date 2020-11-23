# Livewire for Twig

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)
![GitHub Workflow Status](https://github.com/enflow/livewire-twig/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)

The `enflow/livewire-twig` package provides the option to load Livewire components in your Twig templates.

## Installation
You can install the package via composer:

``` bash
composer require enflow/livewire-twig
```

## Usage
The Twig extension will automatically register when `rcrowe/twigbridge` is used.
If you're using another configuration, you may wish to register the extension manually by loading the extension `Enflow\LivewireTwig\LivewireExtension`.

This package only provides a wrapper for the `@livewireScripts`, `@livewireStyles` & `@livewire` calls. Everything else under the hood is powered by `livewire/livewire`.   
You can register your Livewire components like normal. 

## Installation

Add the following tags in the `head` tag, and before the end `body` tag in your template.

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
{% livewire counter %}

{# If you wish to pass along variables to your component #}
{% livewire counter with {'count': 3} %}
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

## Caveats
- Components with hyphens cannot be called like `{% livewire foo-bar %}` as Twig doesn't allow hyphens like that. We've added a workaround for this by allowing camel case: `{% livewire fooBar %}`

## Todo
- [ ] Implement support for `key` tracking
- [ ] Implement support for preserving child tracking
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
