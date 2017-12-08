<?php
namespace Dsheiko\Validate;

trait ValidateMapTrait
{
    /**
     * Extract MANDATORY/OPTIONAL from the contract
     *
     * @param array $contract
     * @return boolean
     * @throws \RuntimeException
     */
    protected static function getMapEntryContractOptionality(array $contract)
    {
        $opt = array_shift($contract);
        if (!in_array($opt, [static::MANDATORY, static::OPTIONAL], true)) {
            throw new \RuntimeException("Contract " . json_encode($contract) . " is invalid");
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
        array_shift($contract);
        // $contracts can be mixed = [string, array[key -> value ]]
        $values = array_values($contract);
        //  ["IsInt, NotEmpty"]
        if (count($contract) === 1 && is_string($values[0])) {
            return static::normalizeValidatorContract($values[0]);
        }
        return count($contract) ? static::normalizeValidatorContract($contract) : null;
    }
    /**
     * [static::MANDATORY] => [static::MANDATORY]
     * static::MANDATORY => [static::MANDATORY]
     *
     * @param array|boolean $contract
     * @return array
     */
    protected static function normalizeOptionContract($contract)
    {
        if (!is_array($contract)) {
            $contract = [$contract];
        }
        return $contract;
    }
    /**
     * Validate map array against an array of contracts
     *
     * @param array $options
     * @param array $contracts
     * @throws Exception
     */
    public static function map(array $options, array $contracts)
    {
        $allowed = [];
        array_walk($contracts, function ($rawContract, $key) use ($options, &$allowed) {
            $contract = static::normalizeOptionContract($rawContract);
            $opt = static::getMapEntryContractOptionality($contract);
            $validators = static::getMapEntryContractValidators($contract);

            if ($opt === static::MANDATORY && !isset($options[$key])) {
                throw new Exception("Property {$key} is mandatory!");
            }
            if (in_array($opt, [static::MANDATORY, static::OPTIONAL], true)) {
                $allowed[] = $key;
            }
            if ($validators) {
                $value = $options[$key];
                return array_walk($validators, function ($options, $method) use ($value) {
                    static::validateContract($value, $method, $options);
                });
            }
        });
        if (!count($allowed)) {
            return;
        }
        // $params contains keys that not present in $allowed
        if (count(array_diff(array_keys($options), $allowed))) {
            throw new Exception(
                "Only following keys " . \implode(",", $allowed)
                . " allowed"
            );
        }
    }
}
