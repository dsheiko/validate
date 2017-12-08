<?php
namespace Dsheiko\Validate\IsInt\Min;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too low; must be more than {min}';
}
