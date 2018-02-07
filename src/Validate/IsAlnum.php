<?php
namespace Dsheiko\Validate;

class IsAlnum extends IsString implements ValidateInterface
{
    protected static $options = [ "notEmpty" => true, "isAlnum" => true ];
    /**
     * @param mixed $value - a value to validate
     * @return boolean
     */
    public static function testOptionIsAlnum($value): bool
    {
        return (bool) preg_match("/^[\p{L}\p{Nd}]+$/u", $value);
    }
}
