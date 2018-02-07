<?php
namespace Dsheiko\Validate;

class IsArray extends ValidateAbstract implements ValidateInterface
{
   /**
    * Main validation method
    *
    * @inheritDoc
    */
    public static function test($value): bool
    {
        return \is_array($value);
    }
}
