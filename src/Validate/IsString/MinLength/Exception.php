<?php
namespace Dsheiko\Validate\IsString\MinLength;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too short; must be more than {minLength} chars';
}
