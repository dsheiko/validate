<?php
namespace Dsheiko\Validate;

trait ValidateProcessorTrait
{
    /**
     * Normalize value to include as a string into Exception message
     * @param mixed $value
     * @return string
     */
    protected static function normalizeValue($value)
    {
        $json = json_encode($value);
        return strlen($json) > static::DISPLAY_VALUE_MAX_LEN
            ? substr($json, 0, static::DISPLAY_VALUE_MAX_LEN) . ".." : $json;
    }
    /**
     * Retrieve from class name the corresponding exception class
     * ('Validate\IsInt') => Validate\IsInt\Exception
     * ('Validate\IsInt', 'min') => Validate\IsInt\Min\Exception
     *
     * @param string $class
     * @param string $option - validator option e.g. min
     * @return string
     */
    protected static function getExceptionClass($class, $option = null)
    {
        return "\\" . \ltrim($class, "\\") . "\\" .
            ( $option ? ucfirst($option) . "\\" : "" ) . "Exception";
    }
    /**
     * Throw a corresponding exception
     * The exception message is either default or (if $tplData given) generated message
     * @param string $class
     * [@param string $option]  - validator option e.g. min
     * [@param array $tplData]
     * @throws \Validate\Exception
     */
    protected static function throwException($class, $option = null, array $tplData = null)
    {
        $exClass = static::getExceptionClass($class, $option);
        $msg = $tplData ? strtr($exClass::$tpl, $tplData) : "Value is not valid";
        if (!class_exists($exClass)) {
            throw new \RuntimeException("Exception class `{$exClass}` not found for {$class}");
        }
        throw new $exClass($msg);
    }
    /**
     * Obtain option test method name
     * ('min') => testOptionMin
     *
     * @param string $option
     * @return string
     */
    protected static function getOptionTestMethod($option)
    {
        return "testOption" . ucfirst($option);
    }

    /**
     * Make an array of replacement in mustasche style
     * (1, ['min'=>2]) => ['{value}'='1', '{min}'=> '2']
     *
     * @param mixed $value
     * [@param array $options]
     * @return array
     */
    protected static function prepareTplData($value, array $options = null)
    {
        $data = ["{value}" => static::normalizeValue($value)];
        $options && array_walk($options, function ($constraint, $option) use (&$data) {
            $data["{" . $option . "}"] = (string)$constraint;
        });
        return $data;
    }
}
