<?php
namespace Dsheiko\Validate\IsAlpha\NotEmpty;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} string must not be empty or consist of whitespaces';
}
