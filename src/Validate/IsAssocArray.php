<?php
namespace Dsheiko\Validate;

class IsAssocArray extends ValidateAbstract implements ValidateInterface
{
   /**
    * Main validation method
    *
    * @inheritDoc
    */
    public static function test($value): bool
    {
        if ([] === $value) {
            return false;
        }
        return \array_keys($value) !== \range(0, \count($value) - 1);
    }
}
