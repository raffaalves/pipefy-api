# pipefy-api
PHP wrapper for the Pipefy API

## Requirements
PHP 7.3+

## Installation

Via composer:

```sh
composer require raffaalves/pipefy-api
```

## Documentation


## Tutorial
$pipefy = new Pipefy('api_key');

$pipefy->query(object/function, Input fields, Return fields)

$pipefy->mutation(object/function, Input fields, Return fields)

```php
// get card
$pipefy = new Pipefy('api_key');
$card = $pipefy->query('card', ['id' => 99999], ['title']);

// create card
$pipefy = new Pipefy('api_key');
$data = [
    'pipe_id' => '301692098',
    'title' => 'Teste 22'
];
$card = $pipefy->mutation('createCard', $data, ['card' => ['id']]);
```


## Useful links
* [Pipefy Official API Documentation](https://api-docs.pipefy.com/reference/overview/Card/)
* [GraphQl website](http://graphql.org)

* [MIT License](../master/LICENSE)
