<?php

namespace Vendelev\Service\ExampleTest;

use Vendelev\Service\Example\Lib\Pinba;

class PinbaTest extends AbstractTest
{
    /**
     * @var string Название тестируемого класса для вызова private метода
     */
    protected $className = '\Vendelev\Service\Example\Lib\Pinba';

    /**
     * @test
     */
    public function me()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        /** @var Pinba $name */
        $name = $this->getClassName();

        $this->assertEquals($name::me(), $name::me());
    }

    /**
     * @test
     */
    public function successTimerStart()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getClassObject()->timerStart('test', ['t2' => 'value']);
        $this->getClassObject()->timerStart('test', ['t2' => 'value']);

        $this->getClassObject()->setEnabled(true);
        $this->getClassObject()->timerStart('test1', ['t2' => 'value']);
        $this->getClassObject()->timerStart('test2', ['t2' => 'value']);

        $this->getClassObject()->timerStop('test2');
        $this->getClassObject()->timerStart('test2', ['t2' => 'value']);

        $this->getClassObject()->timerDelete('test2');
        $this->getClassObject()->timerStart('test2', ['t2' => 'value']);
    }

    /**
     * Нельзя запускать несколько таймеров с одним названием одновременно
     *
     * @test
     * @expectedException \Exception
     */
    public function failTimerStart()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getClassObject()->setEnabled(true);
        $this->getClassObject()->timerStart('test', ['t2' => 'value']);
        $this->getClassObject()->timerStart('test', ['t2' => 'value']);
    }

    /**
     * Информацию о таймере можно получить только когда он запущен
     *
     * @test
     */
    public function successTimerGetInfo()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getClassObject()->setEnabled(true);
        $this->getClassObject()->timerStart('test', ['t2' => 'value']);
        $this->getClassObject()->timerGetInfo('test');
    }

    /**
     * При выключенном состоянии должен возвращаться пустой массив
     *
     * @test
     */
    public function failTimerGetInfoWithDisabled()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $result = $this->getClassObject()->timerGetInfo('test');
        $this->assertEquals([], $result);
    }

    /**
     * При включенном состоянии должно бросаться исключение
     *
     * @test
     * @expectedException \Exception
     */
    public function failTimerGetInfoWithEnabled()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->getClassObject()->setEnabled(true);
        $this->getClassObject()->timerGetInfo('test');
    }


    /**
     * @return Pinba
     */
    public function getClassObject()
    {
        /** @var Pinba $returnValue */
        $returnValue = parent::getClassObject();

        return $returnValue;
    }

    protected function setUp()
    {
        $name = $this->getClassName();
        $this->setClassObject(new $name());
        $this->getClassObject()->setEnabled(false);
    }
}
