<?php
namespace Dsheiko\Validate\IsInt\Max;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too hight; must be less than {max}';
}
