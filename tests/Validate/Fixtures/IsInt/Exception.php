<?php
namespace Fixtures\IsInt;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not an integer';
}
