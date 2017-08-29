<?php

namespace Vendelev\Service\ExampleTest;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

abstract class AbstractTest extends TestCase
{
    /**
     * @var object Инстанс тестируемого класса для вызова private метода
     */
    protected $classObject = null;

    /**
     * @var string Название тестируемого класса для вызова private метода
     */
    protected $className = '';

    /**
     * Получение методов private и protected
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   string $className
     * @param   string $methodName
     *
     * @return  ReflectionMethod
     */
    protected function getPrivateMethod($className, $methodName)
    {
        $reflector = new ReflectionClass($className);
        $method    = $reflector->getMethod($methodName);
        $method->setAccessible(true);
 
        return $method;
    }

    /**
     * Вызов private метода
     * 
     * @param string $method
     * @param array $args
     *
     * @return mixed
     */
    protected function callPrivateMethod($method, $args=array())
    {
        $result = null;
        $class  = $this->getClassObject();
        $name   = $this->getClassName();

        if ($class && $name) {
            $method = $this->getPrivateMethod($name, $method);
            $result = $method->invokeArgs($class, $args);
        } else {
            $this->markTestIncomplete('Не задан объект');
        }

        return $result;
    }

    /**
     * @return object
     */
    public function getClassObject()
    {
        return $this->classObject;
    }

    /**
     * @param object $classObject
     *
     * @return $this
     */
    public function setClassObject($classObject)
    {
        $this->classObject = $classObject;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return $this
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }
}