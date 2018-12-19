Overview
========
Token open source SDKs simplify the interactions with the Token global open banking REST/gRPC API.
The Token SDKs handle digital signatures and, where applicable, chain Token API calls. This makes
it easier to develop Token-integrated applications, while providing most of the flexibility of
the full Token API.
More information at [https://developer.token.io/sdk/](https://developer.token.io/sdk/)

## Requirements

* PHP 5.5.0 and later.

* [gRPC PHP extension](https://grpc.io/docs/quickstart/php.html#install-the-grpc-php-extension).

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require tokenio/sdk
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```
## Build
To build the SDK:

```sh build.sh```

This command will download latest protos, run tests and generate documentation.
## Dependencies

The bindings require the following extensions in order to work properly:

- [`grpc`](https://grpc.io/docs/quickstart/php.html)
- [`sodium`](http://php.net/manual/en/book.sodium.php)
- [`bcmath`](http://php.net/manual/en/book.bc.php)
- [`json`](http://php.net/manual/en/book.json.php)

Please do not install `ext-protobuf`, Token SDK works with PHP implementation of Protobuf (package google/protobuf).
