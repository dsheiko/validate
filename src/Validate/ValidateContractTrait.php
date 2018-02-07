<?php
namespace Dsheiko\Validate;

use Dsheiko\Validate\IsAssocArray;
use Dsheiko\Validate\Exception;

trait ValidateContractTrait
{
    /**
     * Convert ['ValidatorFoo', 'ValidatorBar' => []] to ['ValidatorFoo' => null, 'ValidatorBar' => []]
     * @param array $contract
     * @return array
     */
    protected static function normalizeArrayContract($contract): array
    {
        $normalized = [];
        \array_walk($contract, function ($val, $key) use (&$normalized) {
            if (\is_int($key)) {
                $normalized[$val] = null;
                return;
            }
            $normalized[$key] = $val;
        });
        return $normalized;
    }
    /**
     * Convert string/array raw contract into normalized [ ValidatorName => null | options ]
     * @param string|array $rawContract
     * @return array
     * @throws \RuntimeException
     */
    protected static function normalizeValidatorContract($rawContract): array
    {
        // 'isString , NotEmpty' ['isString' => null, 'NotEmpty' => null]
        if (\is_string($rawContract)) {
            $methods = \explode(",", \preg_replace("/\s/", "", $rawContract));
            return \array_fill_keys($methods, null);
        }
        if (!\is_array($rawContract)) {
            throw new \InvalidArgumentException("Invalid contract supplied: " . \json_encode($rawContract));
        }
        return static::normalizeArrayContract($rawContract);
    }
    /**
     * Validate value against supplied validator
     * @param mixed $value
     * @param string $validatorName
     * @param array|null $options
     */
    protected static function validateContract($value, string $validatorName, $options)
    {
        $validate = new self();
        $validate->factory($validatorName)->validate($value, $options);
    }

    /**
     * Validate list of specs
     *
     * Syntax:
     * Validate::contract( spec )
     *
     * where
     * spec = [ parameterName => obligation, .. ]
     *
     * where
     * obligation = [ value, contract ]
     *
     * @example
     * Validate::contract([
     *   'foo' => [ 1, ['isString', 'NotEmpty'],
     *   'bar' => [ 2, ['isInt' => ['min' => 10]],
     * ]);
     *
     * @param array $spec key-value array
     * @param string [$exDelegate]  an exception class for delegation
     * @throws \Dsheiko\Validate\Exception for validation exceptions
     * @throws \InvalidArgumentException for syntax exception
     * @throws \Exception for type hinting
     */
    public static function contract(array $spec, string $exDelegate = null)
    {
        if (!IsAssocArray::test($spec)) {
            throw new \InvalidArgumentException(
                "Invalid schema supplied; must be a key-value array [ parameter => obligation ]"
            );
        }
        \array_walk($spec, function ($valContract, $param) use ($exDelegate) {
            if (!\is_array($valContract) || count($valContract) !== 2) {
                throw new \InvalidArgumentException("Invalid obligation supplied; must be [ value, contract ]");
            }
            list($value, $rawContract) = $valContract;
            try {
                static::validateRawContract($value, $rawContract);
            } catch (Exception $e) {
                $exClass = $exDelegate ?: \get_class($e);
                throw new $exClass("Parameter \"{$param}\" validation failed: " . $e->getMessage(), $e->getCode(), $e);
            }
        });
    }

    /**
     * Validate value against a raw contract
     * @param mixed $value - test target
     * @param mixed $rawContract - can be 'isString' or ['isString', 'NotEmpty'] or ['isInt' => ['min' => 10]] ]
     * @throws \Dsheiko\Validate\Exception for validation exceptions
     * @throws \InvalidArgumentException for syntax exception
     * @throws \Exception for type hinting
     */
    private static function validateRawContract($value, $rawContract)
    {
        $contract = static::normalizeValidatorContract($rawContract);
        array_walk($contract, function ($options, $method) use ($value) {
            static::validateContract($value, $method, $options);
        });
    }
}
