<?php
namespace Dsheiko\Validate;

class IsString extends ValidateAbstract
{

    /**
     * Test if a supplied string is not empty
     *
     * @param string $value
     * @return bool
     */
    public static function testOptionNotEmpty($value)
    {
        return strlen(trim($value)) > 0;
    }

    /**
     * Test if a supplied longer complies minimal allowed length
     *
     * @param string $value
     * @param int $constraint
     * @return bool
     */
    public static function testOptionMinLength($value, $constraint)
    {
        return strlen($value) >= $constraint;
    }

    /**
     * Test if a supplied longer complies maximal allowed length
     *
     * @param string $value
     * @param int $constraint
     * @return bool
     */
    public static function testOptionMaxLength($value, $constraint)
    {
        return strlen($value) <= $constraint;
    }

    /**
     * Main validation method
     *
     * @inheritDoc
     */
    public static function test($value)
    {
        return is_string($value);
    }
}
