<?php
namespace Dsheiko\Validate;

use Dsheiko\Validate as ValidateChain;
use Dsheiko\Validate\Exception;

abstract class ValidateAbstract
{
    use ValidateProcessorTrait;

    // The value get json-encoded and shown in the error messages
    // this constraint sets what part of json we show if it's to long
    const DISPLAY_VALUE_MAX_LEN = 10;

    /**
     * Validate $value and throw exception if invalid
     *
     * @param mixed $value
     * [@param array $optionsParam]
     * @throws \Dsheiko\Validate\Exception
     * @return void
     */
    public function validate($value, array $optionsParam = null)
    {
        $class = \get_called_class();
        // If validator defines options they are taken
        $options = static::$options ?? $optionsParam;
        $tplData = static::prepareTplData($value, $options);
        if (!static::test($value)) {
            static::throwException($class, null, $tplData);
        }
        if (!$options) {
            return;
        }
        foreach ($options as $option => $constraint) {
            $test = static::getOptionTestMethod($option);
            if (!\method_exists($class, $test)) {
                throw new \RuntimeException("Method to test `{$option}` option ({$test}) not found in {$class}");
            }
            if (!static::$test($value, $constraint)) {
                static::throwException($class, $option, $tplData);
            }
        }
    }
    /**
     * Check if the value is valid, persist exception
     *
     * @param mixed $value
     * [@param array $options]
     * @return boolean
     */
    public function isValid($value, array $options = null): bool
    {
        try {
            $this->validate($value, $options);
            return true;
        } catch (\Dsheiko\Validate\Exception $ex) {
            $this->exception = $ex;
            return false;
        }
    }
    /**
     * @var string|null
     */
    protected $exception = null;

    /**
     * Add validator into the chain
     *
     * @param \Dsheiko\Validate $chain
     * @param array $arguments
     * @return \Dsheiko\Validate
     */
    public function add(ValidateChain $chain, $value, array $options = null)
    {
        if (!$this->isValid($value, $options)) {
            $chain->setValid(false);
            $chain->pushMessage($this->getMessage());
        }
        return $chain;
    }

    /**
     * Return last exception message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->exception ? $this->exception->getMessage() : null;
    }
    /**
     * Return last thrown exception
     *
     * @return \Dsheiko\Validate\Exception | null
     */
    public function getException()
    {
        return $this->exception;
    }
}
