# Validator Interface

Validators implement `ValidateInterface` and therefore required only a static method `test` that is used to do the main check.

```php
<?php
namespace Dsheiko\Validate;

class IsBool extends ValidateAbstract
{
    public static function test($value)
    {
        return is_bool($value);
    }
}
```

However any validator must be provided with the corresponding Exception class:
```php
<?php
namespace Dsheiko\Validate\IsBool;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a boolean';
}
```

Optional variable `$tpl` contains a template that is used to build the exception message;

## Parameterized validators

When validator receives parameters, each of them shall be provided with the corresponding test method in the manner
`testOption<OptionName>`:

```php
<?php
namespace Dsheiko\Validate;

class IsInt extends ValidateAbstract
{

    public static function testOptionMin($value, $constraint): bool
    {
        return $value >= $constraint;
    }
    public static function testOptionMax($value, $constraint): bool
    {
        return $value <= $constraint;
    }
    public static function test($value): bool
    {
        return is_int($value);
    }

}
```


## Extending validators

Validators can be extended. You just need to provide the options that will be taken as parameters by parent validator

```php
<?php

namespace Dsheiko\Validate\GoogleName;

class Nickname extends \Dsheiko\Validate\IsString
{
    protected static $options = [ "minLength" => 4, "maxLength" => 16, "notEmpty" => true ];
}
```

Child validator can also have own test methods:
```php
<?php
namespace Dsheiko\Validate;

class IsEmailAddress extends IsString
{
    protected static $options = [ "notEmpty" => true, "isEmailAddress" => true ];

    public static function testOptionIsEmailAddress($value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
```

