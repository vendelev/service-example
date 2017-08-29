<?php

namespace Vendelev\Service\ExampleTest;

use GuzzleHttp\Client;
use Vendelev\Service\Example\Lib\HttpClient;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversDefaultClass Vendelev\Service\Example\Lib\HttpClient
 */
class HttpClientTest extends AbstractTest
{
    /**
     * @var string Название тестируемого класса для вызова private метода
     */
    protected $className = '\Vendelev\Service\Example\Lib\HttpClient';

    /**
     * @test
     * @covers ::jsonDecode
     * @expectedException \InvalidArgumentException
     */
    public function jsonDecode()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $result = (new HttpClient())->jsonDecode('{}');
        $this->assertEquals([], $result);
        (new HttpClient())->jsonDecode('{');
    }

    /**
     * @test
     */
    public function getHttpClient()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertInstanceOf(Client::class, (new HttpClient())->getHttpClient());
    }

    /**
     * @test
     */
    public function clientResponse()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->callPrivateMethod('setClientResponse', [$this->createMock(ResponseInterface::class)]);
        $this->assertInstanceOf(ResponseInterface::class, $this->callPrivateMethod('getClientResponse'));
    }

    /**
     * @return HttpClient
     */
    public function getClassObject()
    {
        /** @var HttpClient $returnValue */
        $returnValue = parent::getClassObject();

        return $returnValue;
    }

    protected function setUp()
    {
        $name = $this->getClassName();
        $this->setClassObject(new $name());
    }
}
