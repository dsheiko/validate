<?php
namespace Dsheiko;

/**
 * Helper methods consumed by BDD unit-tests
 */
class Reflection
{
    /**
     * Create callable out of a given static private method
     *
     * @example
     *  $method = Reflection::staticMethod("\\Dsheiko\\Validate", "normalizeArrayContract");
     *  $res = $method([]);
     *
     * @param string $class
     * @param string $method
     *
     * @return function
     */
    public static function staticMethod($class, $method)
    {
        $ref = new \ReflectionMethod($class, $method);
        $ref->setAccessible(true);

        /**
         * @param rest .. $arg1, $arg2
         *
         * @retunr mixed
         * @return mixed
         */
        return function () use ($ref) {
            return $ref->invokeArgs(null, func_get_args());
        };
    }
}
