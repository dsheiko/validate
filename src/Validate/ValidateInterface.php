<?php
namespace Dsheiko\Validate;

interface ValidateInterface
{
    /**
     * Main validation method
     * @param mixed $value - a value to validate
     * @return boolean
     */
    public static function test($value): bool;

    // here excpected methods per option
    // e.g. option is 'min'
    // public static function testOptionMin($value, $constraint): bool
}
