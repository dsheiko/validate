<?php
namespace Dsheiko\Validate\IsIp;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a valid IP address';
}
