<?php
namespace Dsheiko\Validate;

class IsBool extends ValidateAbstract
{
    /**
     * Main validation method
     *
     * @inheritDoc
     */
    public static function test($value)
    {
        return is_bool($value);
    }
}
