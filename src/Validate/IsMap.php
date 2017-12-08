<?php
namespace Dsheiko\Validate;

use Dsheiko\Validate as ValidateLib;

class IsMap extends ValidateAbstract
{
   /**
    * Main validation method (Exceptional case, not used here)
    *
    * @inheritDoc
    */
    public static function test($value)
    {
        return true;
    }

    /**
     * Validate $value and throw exception if invalid
     *
     * @param mixed $value
     * [@param array $optionsParam]
     * @throws \Validate\Exception
     * @return void
     */
    public function validate($value, array $optionsParam = null)
    {
        ValidateLib::map($value, $optionsParam);
    }
}
