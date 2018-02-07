# Dsheiko\Validate

[![Latest Stable Version](https://poser.pugx.org/dsheiko/validate/v/stable)](https://packagist.org/packages/dsheiko/validate)
[![Total Downloads](https://poser.pugx.org/dsheiko/validate/downloads)](https://packagist.org/packages/dsheiko/validate)
[![License](https://poser.pugx.org/dsheiko/validate/license)](https://packagist.org/packages/dsheiko/validate)
[![Build Status](https://travis-ci.org/dsheiko/validate.png)](https://travis-ci.org/dsheiko/validate)

Extendable validation library for testing primitive and complex types (including key-value arrays) against a contract

* [Installation](#installation)
* [Usage](#usage)

## Installation

Require as a composer dependency:

``` bash
composer require "dsheiko/validate"
```

## Highlights
- Validators are dead simple to extend
- It's really easy to validate precondition/postcondition contracts
- Validator assertions are directly accessible
- Validation of nested arrays


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
      "email" => [ $email, "IsEmailAddress" ],
      "password" => [ $password, [ "IsString"=> [ "minLength" => 6, "maxLength" => 32, "notEmpty" => true ] ] ],
    ]);
    // do login
}
```

may throw

- `Dsheiko\Validate\IsString\Exception`
- `Dsheiko\Validate\IsString\minLength\Exception`
- `Dsheiko\Validate\IsString\maxLength\Exception`
- `Dsheiko\Validate\IsEmail\Exception`

with a message like

- Parameter "email" validation failed: "jon#snow.i.." is not a valid email address
- Parameter "password" validation failed: "123" is too short; must be more than 6 chars

### Map Validation
```php
<?php

$params = [
  "email" => "jon#snow.io",
  "password" => "******",
];

Validate::map($params, [
    "email" => ["mandatory", "IsEmailAddress"],
    "password" => ["mandatory", "IsString" => ["minLength" => 6, "maxLength" => 128]],
    "rememberMe" => ["optional", "IsBool" ],
]);

```

Exception messages look like:

- `Property "email" validation failed: "jon#snow.i.." is not a valid email address`
