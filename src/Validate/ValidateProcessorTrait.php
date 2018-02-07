<?php
namespace Dsheiko\Validate;

trait ValidateProcessorTrait
{
    /**
     * Trim supplied string to pass length constraints
     * @param string $string
     * @return string
     */
    private static function trim(string $string): string
    {
        return \strlen($string) > static::DISPLAY_VALUE_MAX_LEN
            ? \substr($string, 0, static::DISPLAY_VALUE_MAX_LEN) . ".." : $string;
    }
    /**
     * Normalize value to include as a string into Exception message
     * @param mixed $value
     * @return string
     */
    protected static function normalizeValue($value): string
    {
        switch (true) {
            case \is_string($value):
                return \json_encode(static::trim($value));
            case \is_string($value):
                return static::trim((string)$value);
            default:
                return static::trim(\json_encode($value));
        }
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
    protected static function getExceptionClass(string $class, string $option = null): string
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
    protected static function throwException(string $class, string $option = null, array $tplData = null)
    {
        $exClass = static::getExceptionClass($class, $option);
        $msg = $tplData ? \strtr($exClass::$tpl, $tplData) : "Value is not valid";
        if (!\class_exists($exClass)) {
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
    protected static function getOptionTestMethod(string $option): string
    {
        return "testOption" . \ucfirst($option);
    }

    /**
     * Make an array of replacement in mustasche style
     * (1, ['min'=>2]) => ['{value}'='1', '{min}'=> '2']
     *
     * @param mixed $value
     * [@param array $options]
     * @return array
     */
    protected static function prepareTplData($value, array $options = null): array
    {
        $data = ["{value}" => static::normalizeValue($value)];
        $options && \array_walk($options, function ($constraint, $option) use (&$data) {
            $data["{" . $option . "}"] = (string)$constraint;
        });
        return $data;
    }
}
