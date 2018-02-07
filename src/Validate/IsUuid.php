<?php
namespace Dsheiko\Validate;

class IsUuid extends ValidateAbstract implements ValidateInterface
{
    /**
     * Asset UUID v4
     *
     * @inheritDoc
     */
    public static function test($value): bool
    {
        $re = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        return \preg_match($re, $value);
    }
}
