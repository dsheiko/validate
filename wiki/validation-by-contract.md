# Validation by Contract

```php
<?php
Validate::contract([
    "foo" => [ 200, [ "IsInt" => [ "min" => 0, "max" => 100 ] ] ],
    "bar" => [ "str", [ "IsString" => [ "minLength" => 0, "notEmpty" => true ] ] ]
]);
```
it throws `Validate\IsInt\Max\Exception: Parameter "foo" validation failed: 200 is too hight; must be less than 100`


## A real-world example

```php
<?php

function log($userId, ...$options)
{
    Validate::contract([
        "userId" => [ $userId, "IsInt" ],
        "options" => [ $options, [
           "IsMap" => [
                "option1" => ["mandatory", "IsBool"],
                "option2" => ["optional", "IsString" => ["minLength" => 6]],
            ]
        ] ],
    ]);
}
```

## Exception Delegation

```php
<?php
Validate::contract([
    "baz" => [ [1, 2, 3], "IsAssocArray" ],
], \InvalidArgumentException::class);
```
it throws `\InvalidArgumentException: Parameter "baz" validation failed: [1,2,3] is not an array`


* [Map Validation](./map-validation.md)