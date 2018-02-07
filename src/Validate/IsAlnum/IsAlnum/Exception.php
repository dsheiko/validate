<?php
namespace Dsheiko\Validate\IsAlnum\IsAlnum;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a letters and digits only';
}
