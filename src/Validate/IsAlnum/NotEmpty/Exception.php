<?php
namespace Dsheiko\Validate\IsAlnum\NotEmpty;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} string must not be empty or consist of whitespaces';
}
