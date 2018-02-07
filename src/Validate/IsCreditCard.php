<?php
namespace Dsheiko\Validate;

class IsCreditCard extends ValidateAbstract implements ValidateInterface
{
    /**
     * Credits to http://web.archive.org/web/20080918014358/http://www.roughguidetophp.com/10-regular-expressions-you-just-cant-live-without-in-php/
     *
     * @param mixed $value - a value to validate
     * @return boolean
     */
    public static function test($value): bool
    {
        $cards = [
            "visa" => "(4\d{12}(?:\d{3})?)",
            "amex" => "(3[47]\d{13})",
            "jcb" => "(35[2-8][89]\d\d\d{10})",
            "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
            "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
            "mastercard" => "(5[1-5]\d{14})",
            "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
        ];
        $matches = [];
        $pattern = "#^(?:" . \implode("|", $cards) . ")$#";
        $result = \preg_match($pattern, \str_replace(" ", "", $value), $matches);
        return ( $result > 0 );
    }
}
