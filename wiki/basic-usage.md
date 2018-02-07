# Basic Usage

```php
<?php
use \Dsheiko\Validate;

$v = new Validate\IsBool();
$v->validate([]);
```
this throws `\Dsheiko\Validate\IsBool\Exception('[] is not a boolean')`

```php
<?php
$v = new Validate\IsString();
$v->validate("12345", ["minLength" => 10, "maxLength" => 1]);
```
this throws `\Dsheiko\Validate\IsString\MinLength\Exception('"12345" is too long; must be less than 10 chars')`


```php
<?php
$v = new Validate\IsString();
echo $v->isValid("12345", ["minLength" => 10, "maxLength" => 1]); // FALSE
echo $v->getMessage(); // the message
```

# Static assertions

```php
<?php
use \Dsheiko\Validate;

$isValid = Validate\IsBool::test([]);

```

* [Implemented Validators](./validators.md)