<?php
namespace Dsheiko\Validate\IsString\MaxLength;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too long; must be less than {maxLength} chars';
}
