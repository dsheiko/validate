<?php
namespace Dsheiko\Validate\IsUrl;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a valid URL';
}
