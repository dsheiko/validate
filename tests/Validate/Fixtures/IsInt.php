<?php
namespace Fixtures;

use Dsheiko\Validate\ValidateAbstract;

class IsInt extends ValidateAbstract
{

    public static function testOptionMin($value, $constraint)
    {
        return $value >= $constraint;
    }
    public static function testOptionMax($value, $constraint)
    {
        return $value <= $constraint;
    }
    public static function test($value)
    {
        return is_int($value);
    }

}
