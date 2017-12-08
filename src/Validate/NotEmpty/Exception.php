<?php
namespace Dsheiko\Validate\NotEmpty;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is required and can\'t be empty';
}
