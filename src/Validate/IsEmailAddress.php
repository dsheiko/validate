<?php
namespace Dsheiko\Validate;

class IsEmailAddress extends IsString
{
    protected static $options = [ "notEmpty" => true, "isEmailAddress" => true ];
    /**
     * @param mixed $value - a value to validate
     * @return boolean
     */
    public static function testOptionIsEmailAddress($value): bool
    {
        return false !== \filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
