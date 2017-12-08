# Validation by Contract

```php
<?php
Validate::contract(
    [ 1, "str" ],
    [
      [ "IsInt" => [ "min" => 0, "max" => 100 ] ],
      [ "IsString" => [ "minLength" => 0, "notEmpty" => true ] ],
   ]);
```
it throws the corresponding exception.


## Contract for maps

```php
<?php

function log($userId, ...$options)
{
    Validate::contract([
            $userId,
            $options
        ], [
        [
            "IsInt"
        ],
        [
           "IsMap" => [
                "option1" => ["mandatory", "IsBool"],
                "option2" => ["optional", "IsString" => ["minLength" => 6]],
            ]
        ],
    ]);
}
```

* [Map Validation](./map-validation.md)