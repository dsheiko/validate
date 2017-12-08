<?php
namespace Dsheiko\Validate;

trait ValidateContractTrait
{
    /**
     * Convert ['foo', 'bar' => []] to ['foo' => null, 'bar' => []]
     * @param array $contract
     * @return array
     */
    protected static function normalizeArrayContract($contract)
    {
        $normalized = [];
        array_walk($contract, function ($val, $key) use (&$normalized) {
            if (is_int($key)) {
                $normalized[$val] = null;
                return;
            }
            $normalized[$key] = $val;
        });
        return $normalized;
    }
    /**
     *
     * @param string|array $contract
     * @return array
     * @throws \RuntimeException
     */
    protected static function normalizeValidatorContract($contract)
    {
        if (is_string($contract)) {
            $methods = explode(",", preg_replace("/\s/", "", $contract));
            return array_fill_keys($methods, null);
        }
        if (!is_array($contract)) {
            throw new \RuntimeException("Invalid contract supplied");
        }
        return static::normalizeArrayContract($contract);
    }
    /**
     *
     * @param string $value
     * @param string $method
     * @param array|null $options
     */
    protected static function validateContract($value, $method, $options)
    {
        $validate = new self();
        $validate->factory($method)->validate($value, $options);
    }
    /**
     * Validate values against contracts
     * Validate::contract(
     *   ['1', 2],
     *   [
     *     ['isString', 'NotEmpty']
     *     ['isInt' => ['min' => 10]]
     *   ]);
     * @param array $values
     * @param array $contracts
     * @throws ValidationException
     */
    public static function contract(array $values, array $contracts)
    {
        array_map(function ($value, $rawContract) {
            if (!$rawContract) {
                return;
            }
            $contract = static::normalizeValidatorContract($rawContract);
            return array_walk($contract, function ($options, $method) use ($value) {
                static::validateContract($value, $method, $options);
            });
        }, $values, $contracts);
    }
}
