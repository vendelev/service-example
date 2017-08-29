<?php

namespace Vendelev\Service\Example\Service;

use Vendelev\Service\Example\Lib\Loggers\LoggerTrait;

class Division
{
    use LoggerTrait;

    /**
     * @param string      $url
     * @param Service     $service
     * @param DivisionDBO $dbo
     */
    public function synchronizeDivisions($url, Service $service, DivisionDBO $dbo)
    {
        $serviceDivs = $service->getDivisions($url);
        $dboDivs     = $dbo->getAll();

        $changes = $this->getDivisionChanges($serviceDivs, $dboDivs);

        if (!empty($changes['updateDivs'])) {
            $dbo->update($changes['updateDivs']);
        }

        if (!empty($changes['insertDivs'])) {
            $dbo->insert($changes['insertDivs']);
        }

        $this->getLogger()->info('Обновление отделов', [
            'recieved' => count($serviceDivs),
            'updated'  => count($changes['updateDivs']),
            'inserted' => count($changes['insertDivs']),
        ]);
    }

    /**
     * @param array $serviceDivs
     * @param array $dboDivs
     *
     * @return array
     */
    public function getDivisionChanges(array $serviceDivs, array $dboDivs)
    {
        $updateDivs  = [];
        $insertDivs  = [];

        foreach ($serviceDivs as $code=>$div) {

            if (!empty($dboDivs[$code])) {
                if ($div != $dboDivs[$code]) {
                    $updateDivs[] = $div;
                }
            } else {
                $insertDivs[] = $div;
            }
        }

        return [
            'updateDivs' => $updateDivs,
            'insertDivs' => $insertDivs,
        ];
    }
}