# Map Validation

The method is used to validate a map-like structure (key-value array)

## Validating optionality

```php
<?php

$options = [ "foo" => 1, "bar" => 9 ];
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
$params = [ "foo" => "foo" ];
Validate::map($params, [
  "foo" => ["mandatory", "IsInt, NotEmpty"]
]);
```
throws `Validate\IsInt\Exception`

### Parameterized validators
```php
<?php
//...
$params = [ "foo" => 1 ];
Validate::map($params, [
  "foo" => ["mandatory", "IsInt" => ["min" => 10], "NotEmpty"]
]);
```
throws Validate\IsInt\Min\Exception


### A real-world example:
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

* [Custom Validators](./validator-interface.md)