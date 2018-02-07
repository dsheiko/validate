# Validator Chain

```php
<?php
use \Dsheiko\Validate;

$v = new Validate;
$v->IsString("str", ["minLength" => 10])
  ->IsInt(0, ["min" => 10]);

var_dump( $v->isValid() );
var_dump( $v->getMessages() );
```

outputs
````
bool(false)

array(2) {
  [0]=>
  string(46) ""str" is too short; must be more than 10 chars"
  [1]=>
  string(34) "0 is too low; must be more than 10"
}

```

* [Validation by Contract](./validation-by-contract.md)