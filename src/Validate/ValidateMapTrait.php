<?php
namespace Dsheiko\Validate;

use Dsheiko\Validate\Exception as ValidateException;

trait ValidateMapTrait
{
    /**
     * Extract MANDATORY/OPTIONAL from the contract
     *
     * @param array $contract
     * @return string
     * @throws \InvalidArgumentException
     */
    protected static function getMapEntryContractOptionality(array $contract): string
    {
        $opt = \array_shift($contract);
        if (!\in_array($opt, [static::MANDATORY, static::OPTIONAL], true)) {
            throw new \InvalidArgumentException("Contract " . \json_encode($contract) . " is invalid");
        }
        return $opt;
    }
    /**
     * Extract validators from the contract
     *
     * @param array $contract
     * @return null|array
     */
    protected static function getMapEntryContractValidators(array $contract)
    {
        // [static::MANDATORY, "IsInt, NotEmpty"]
        \array_shift($contract);
        // $contracts can be mixed = [string, array[key -> value ]]
        $values = \array_values($contract);
        //  ["IsInt, NotEmpty"]
        if (count($contract) === 1 && \is_string($values[0])) {
            return static::normalizeValidatorContract($values[0]);
        }
        return \count($contract) ? static::normalizeValidatorContract($contract) : null;
    }
    /**
     * [static::MANDATORY] => [static::MANDATORY]
     * static::MANDATORY => [static::MANDATORY]
     *
     * @param array|boolean $contract
     * @return array
     */
    protected static function normalizeOptionContract($contract): array
    {
        if (!\is_array($contract)) {
            $contract = [$contract];
        }
        return $contract;
    }
    /**
     * Validate map array against an array of contracts
     *
     * @param array $options
     * @param array $contracts
     * @param string [$exDelegate]  an exception class for delegation
     * @throws \Dsheiko\Validate\Exception for validation exceptions
     * @throws \InvalidArgumentException for syntax exception
     * @throws \Exception for type hinting
     */
    public static function map(array $options, array $contracts, string $exDelegate = null)
    {
        \array_walk($contracts, function ($rawContract, $key) use ($options, $exDelegate) {
            $contract = static::normalizeOptionContract($rawContract);
            $opt = static::getMapEntryContractOptionality($contract);
            $validators = static::getMapEntryContractValidators($contract);

            if ($opt === static::MANDATORY && !isset($options[$key])) {
                throw new ValidateException("Property \"{$key}\" is mandatory");
            }

            if ($opt === static::OPTIONAL && !isset($options[$key])) {
                return;
            }

            if (!$validators) {
                return;
            }

            static::validateMapProperty($key, $options[$key], $validators, $exDelegate);
        });
    }

    /**
     * Validate map property
     * @param string $prop
     * @param mixed $value
     * @param array $validators
     * @param string [$exDelegate] an exception class for delegation
     * @throws \Dsheiko\Validate\Exception for validation exceptions
     * @throws \InvalidArgumentException for syntax exception
     * @throws \Exception for type hinting
     */
    public static function validateMapProperty(string $prop, $value, array $validators, string $exDelegate = null)
    {
        try {
            \array_walk($validators, function ($options, $method) use ($value) {
                static::validateContract($value, $method, $options);
            });
        } catch (Exception $e) {
            $exClass = $exDelegate ?: \get_class($e);
            throw new $exClass("Property \"{$prop}\" validation failed: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
