<?php
namespace Dsheiko\Validate\IsEmailAddress\IsEmailAddress;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a valid email address';
}
