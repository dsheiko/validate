<?php
namespace Fixtures\IsInt\Max;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is too low; must be more than {max}';
}
