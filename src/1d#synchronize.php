<?php

namespace Vendelev\Service\Example;

use Exception;
use Vendelev\Service\Example\Service\Division;
use Vendelev\Service\Example\Service\DivisionDBO;
use Vendelev\Service\Example\Service\Service;
use Vendelev\Service\Example\Lib\PoolConfig;
use Vendelev\Service\Example\Lib\HttpClient;
use Vendelev\Service\Example\Lib\Pinba;
use Vendelev\Service\Example\Lib\Loggers\LoggerPool;

$client = new HttpClient();
$logger = LoggerPool::create('Division', 'graylog');
$url    = PoolConfig::me()->get('rnip')->get('divisions/service/url');
$dbo    = new DivisionDBO();
$service= (new Service())
            ->setHttpClient($client)
            ->setLogger($logger)
            ->setMonitoring(Pinba::me());

try {

    (new Division())
        ->setLogger($logger)
        ->synchronizeDivisions($url, $service, $dbo);

} catch (Exception $e) {
    $logger->exception($e);
}