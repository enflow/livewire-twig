# Livewire for Twig

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)
![GitHub Workflow Status](https://github.com/enflow-nl/livewire-twig/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/livewire-twig.svg?style=flat-square)](https://packagist.org/packages/enflow/livewire-twig)

The `enflow/livewire-twig` package provides the option to load Livewire components in your Twig templates.

**Note: this is very much a proof of concept at the moment.** 

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

## Example
```
{{ livewireStyles() }}

{# The Twig version of '@livewire' #}
{% livewire counter %}

{# If you wish to pass along variables to your component #}
{% livewire counter with {'count': 3} %}

{{ livewireScripts() }}
```

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
