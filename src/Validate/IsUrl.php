<?php
namespace Dsheiko\Validate;

class IsUrl extends ValidateAbstract implements ValidateInterface
{
    /**
     * Main validation method
     *
     * @inheritDoc
     */
    public static function test($value): bool
    {
        return \filter_var($value, \FILTER_VALIDATE_URL);
    }
}
