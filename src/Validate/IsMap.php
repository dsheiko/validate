<?php
namespace Dsheiko\Validate;

use Dsheiko\Validate as ValidateLib;

class IsMap extends ValidateAbstract
{
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
