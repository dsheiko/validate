<?php
namespace Dsheiko\Validate;

class IsAlpha extends IsString implements ValidateInterface
{
    protected static $options = [ "notEmpty" => true, "isAlpha" => true ];
    /**
     * @param mixed $value - a value to validate
     * @return boolean
     */
    public static function testOptionIsAlpha($value): bool
    {
        return (bool) preg_match("/^[\p{L}]+$/u", $value);
    }
}
