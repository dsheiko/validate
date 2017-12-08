# Dsheiko\Validate

[![Latest Stable Version](https://poser.pugx.org/dsheiko/validate/v/stable)](https://packagist.org/packages/dsheiko/validate)
[![Total Downloads](https://poser.pugx.org/dsheiko/validate/downloads)](https://packagist.org/packages/dsheiko/validate)
[![License](https://poser.pugx.org/dsheiko/validate/license)](https://packagist.org/packages/dsheiko/validate)
[![Build Status](https://travis-ci.org/dsheiko/validate.png)](https://travis-ci.org/dsheiko/validate)

Validation library for testing complex types (including key-value arrays) against a contract

* [Installation](#installation)
* [Usage](#usage)

## Installation

Require as a composer dependency:

``` bash
composer require "dsheiko/validate"
```

## Usage

- [Basic Usage](./wiki/basic-usage.md)
- [Validator Chain](./wiki/validator-chain.md)
- [Validation by Contract](./wiki/validation-by-contract.md)
- [Map Validation](./wiki/map-validation.md)
- [Custom Validators](./wiki/validator-interface.md)

## Examples


### Design by Contract
```php
<?php
use \Dsheiko\Validate;

function login($email, $password)
{
    Validate::contract([
            $email,
            $password
        ], [
        [
            "IsEmail",
            "IsString"=> [ "minLength" => 6, "maxLength" => 32, "notEmpty" => true ],
        ],
    ]);
    // do login
}

// may throw
// App\Lib\Validate\IsString
// App\Lib\Validate\IsString\minLength\Exception
// App\Lib\Validate\IsString\maxLength\Exception
// App\Lib\Validate\IsEmail
```

### Map Validation
```php
<?php

$params = [
  "email" => "john@snow.io",
  "password" => "******",
];

Validate::map($params, [
    "email" => ["mandatory", "IsEmail"],
    "password" => ["mandatory", "IsString" => ["minLength" => 6, "maxLength" => 128]],
    "rememberMe" => ["optional", "IsBool" ],
]);

```