<?php
namespace Dsheiko\Validate\IsUuid;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a valid UUID v4';
}
