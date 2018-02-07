# Map Validation

The method is used to validate a map-like structure (key-value array)

## Validating optionality

```php
<?php

$options = [ "foo" => 1 ];
Validate::map($options, [
  "foo" => "mandatory",
  "bar" => "optional"
]);
```

## Validating by Contract

### List of validators as a string:
```php
<?php
//...
$params = [ "foo" => "FOO" ];
Validate::map($params, [
  "foo" => ["mandatory", "IsInt, NotEmpty"]
]);
```
throws `Validate\IsInt\Exception: Property "foo" validation failed: "FOO" is not an integer`

### Parameterized validators
```php
<?php
//...
$params = [ "foo" => 1 ];
Validate::map($params, [
  "foo" => ["mandatory", "IsInt" => ["min" => 10], "NotEmpty"]
]);
```
throws `Validate\IsInt\Min\Exception: Property "foo" validation failed: 1 is too low; must be more than 10`


### A real-world example
```php
<?php
public function authLogin(array $params)
{
    Validate::map($params, [
        "email" => ["mandatory", "IsEmail"],
        "password" => ["mandatory", "IsString"=> [ "minLength" => 6, "maxLength" => 32, "notEmpty" => true ]],
        "apikey" => ["optional", "IsString"],
        "accesskey" => ["optional", "IsString"],
        "rememberme" => ["optional", "IsBool"],
    ]);
//...
}
```

## Exception Delegation

```php
<?php
Validate::map(["foo" => "FOO"], [
    "foo" => [Validate::OPTIONAL, "IsInt"],
], \InvalidArgumentException::class);
```
it throws `\InvalidArgumentException: Property "foo" validation failed: "FOO" is not an integer`

* [Custom Validators](./validator-interface.md)