<?php
namespace Dsheiko\Validate;

class NotEmpty extends ValidateAbstract
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
