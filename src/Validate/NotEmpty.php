<?php
namespace Dsheiko\Validate;

class NotEmpty extends ValidateAbstract implements ValidateInterface
{
   /**
    * Main validation method
    *
    * @inheritDoc
    */
    public static function test($value)
    {
        return is_string($value) ? (bool)trim($value) : (bool)$value;
    }
}
