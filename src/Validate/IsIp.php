<?php
namespace Dsheiko\Validate;

class IsIp extends ValidateAbstract implements ValidateInterface
{
    /**
     * Main validation method
     *
     * @inheritDoc
     */
    public static function test($value): bool
    {
        return \filter_var($value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4 | \FILTER_FLAG_IPV6) !== false;
    }
}
