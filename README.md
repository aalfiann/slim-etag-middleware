# Slim ETag Middleware

[![Version](https://img.shields.io/packagist/v/aalfiann/slim-etag-middleware.svg)](https://packagist.org/packages/aalfiann/slim-etag-middleware)
[![Downloads](https://img.shields.io/packagist/dt/aalfiann/slim-etag-middleware.svg)](https://packagist.org/packages/aalfiann/slim-etag-middleware)
[![License](https://img.shields.io/packagist/l/aalfiann/slim-etag-middleware.svg)](https://github.com/aalfiann/slim-etag-middleware/blob/HEAD/LICENSE.md)

ETag Middleware for Slim Framework 3.

## Installation

Install this package via [Composer](https://getcomposer.org/).
```
composer require "aalfiann/slim-etag-middleware:^1.0"
```


## Usage Example

```php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \aalfiann\Slim\Middleware\ETag;

// Initialize Slim App
$app = new \Slim\App($settings);

// create route /
$app->get('/', function (Request $request, Response $response) {
    $data = ['title' => 'hello world'];
    // create new strong etag. eg: "abc"
    return $response
        ->withHeader('ETag','"abc"')
        ->withJson($data,200,JSON_PRETTY_PRINT);
})
    // this etag middleware will check is current etag same as request etag or not?
    // if same then response header will be 304 Not Modified and empty body.
    ->add(new EtagMiddleware('abc','strong'))
    ->setName("/");

$app->run();
```

## Note
This etag middleware are used in my project >> [Slim API Skeleton](https://github.com/aalfiann/slim-api-skeleton).