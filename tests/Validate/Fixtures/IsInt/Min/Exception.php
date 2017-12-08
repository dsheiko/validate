<?php
namespace Fixtures\IsInt\Min;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too hight; must be less than {min}';
}
