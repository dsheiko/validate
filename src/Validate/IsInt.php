<?php
namespace Dsheiko\Validate;

class IsInt extends ValidateAbstract
{
    /**
     * Test if a supplied value greater than the constraint
     *
     * @param int $value
     * @param int $constraint
     * @return bool
     */
    public static function testOptionMin($value, $constraint)
    {
        return $value >= $constraint;
    }

    /**
     * Test if a supplied value lesser than the constraint
     *
     * @param int $value
     * @param int $constraint
     * @return bool
     */
    public static function testOptionMax($value, $constraint)
    {
        return $value <= $constraint;
    }

    /**
     * Main validation method
     *
     * @inheritDoc
     */
    public static function test($value)
    {
        return is_int($value);
    }
}
