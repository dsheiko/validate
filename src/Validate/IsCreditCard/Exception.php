<?php
namespace Dsheiko\Validate\IsCreditCard;

class Exception extends \Dsheiko\Validate\Exception
{
    public static $tpl = '{value} is not a valid credit card number';
}
