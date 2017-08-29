<?php

namespace Vendelev\Service\ExampleTest;

use Vendelev\Service\Example\Lib\HttpClient;
use Vendelev\Service\Example\Service\Service;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @coversDefaultClass Vendelev\Service\Example\Service\Service
 */
class ServiceTest extends AbstractTest
{
    /**
     * @test
     * @covers ::setHttpClient
     * @covers ::getHttpClient
     */
    public function httpClient()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $result = (new Service())
                    ->setHttpClient(new HttpClient())
                    ->getHttpClient();
        $this->assertInstanceOf(HttpClient::class, $result);
    }

    /**
     * @test
     * @covers ::convertNameFields
     */
    public function convertNameFields()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $equals = [
            'CODE1' => [
                'CODE'     => 'CODE1',
                'FULLNAME' => 'FULLNAME',
                'FIAS_ID'  => 'FIAS_ID',
                'UPDATED'  => 1490240511,
            ],
            'CODE2' => [
                'CODE'       => 'CODE2',
                'FULLNAME'   => 'FULLNAME',
                'FIAS_ID'    => 'FIAS_ID',
                'POST_INDEX' => 'POST_INDEX',
                'ADDR'       => 'ADDR',
                'UPDATED'    => 1490240511,
            ],
        ];

        $result = (new Service())->convertNameFields(
            [
                [
                    'divCode'       => 'CODE1',
                    'divFullName'   => 'FULLNAME',
                    'divUpdated'    => '2017-03-23 06:41:51',
                    'divFiasId'     => 'FIAS_ID',
                    'test'          => 'test',
                ],
                [
                    'divCode'       => 'CODE2',
                    'divFullName'   => 'FULLNAME',
                    'divFiasId'     => 'FIAS_ID',
                    'divIndex'      => 'POST_INDEX',
                    'divAddr'       => 'ADDR',
                    'divUpdated'    => '2017-03-23 06:41:51',
                ],
            ]
        );

        $this->assertEquals($equals, $result);
        $this->assertEquals([], (new Service())->convertNameFields([]));
    }

    /**
     * @test
     * @covers ::getDivisions
     */
    public function getDivisions()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        /** @var PHPUnit_Framework_MockObject_MockObject|Service $mock */
        $mock = $this->getMockBuilder(Service::class)
                     ->setMethods(['checkUrl'])
                     ->getMock();

        $mock->method('checkUrl')
             ->will($this->returnValue(false));

        $result = $mock->getDivisions('');
        $this->assertEquals([], $result);
    }

    /**
     * @test
     * @covers ::checkUrl
     */
    public function checkUrl()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertTrue((new Service())->checkUrl('test'));
    }

    /**
     * @test
     * @covers ::checkUrl
     * @expectedException \Exception
     * @expectedExceptionCode 400
     */
    public function checkUrlFault()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        (new Service())->checkUrl('');
    }

    /**
     * @test
     * @covers ::checkResponse
     */
    public function checkResponse()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertTrue((new Service())->checkResponse(200, 'test'));
    }

    /**
     * @test
     * @covers ::checkResponse
     * @expectedException \Exception
     * @expectedExceptionCode 300
     */
    public function checkResponseFault()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        (new Service())->checkResponse(300, 'test');
    }

    /**
     * @test
     * @covers ::checkJson
     */
    public function checkJson()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertTrue((new Service())->checkJson(['status' => 'test']));
    }

    /**
     * @test
     * @covers ::checkJson
     * @expectedException \Exception
     * @expectedExceptionCode 405
     */
    public function checkJsonFault()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        (new Service())->checkJson([]);
    }

    /**
     * @test
     * @covers ::checkSatus
     */
    public function checkSatus()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertTrue((new Service())->checkSatus(['status' => 'OK']));
    }

    /**
     * @test
     * @covers ::checkSatus
     * @expectedException \Exception
     * @expectedExceptionCode 406
     */
    public function checkSatusFault()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        (new Service())->checkSatus(['status' => 'test']);
    }
}
