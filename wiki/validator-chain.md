# Validator Chain

```php
<?php
use \Dsheiko\Validate;

$v = new Validate;
$v->IsString("str", ["minLength" => 10])
  ->IsInt(0, ["min" => 10]);
echo $v->isValid(); // false
var_dump($v->getMessages());
```

