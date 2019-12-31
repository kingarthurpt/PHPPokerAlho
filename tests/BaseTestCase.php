<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * Allow access to protected or private functions of an object
     *
     * @param object &$object    The object
     * @param string $methodName The protected or private function's name
     * @param array  $params Parameters to pass to the function
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $params = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $params);
    }

    /**
     * Get the value of a protected or private property
     *
     * @param  object &$object The object of the protected or private property
     * @param  string $propertyName The property's name
     *
     * @return mixed The property's value
     */
    protected function getPropertyValue(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
