<?php

namespace Vendelev\Service\Example\Service;


use DateTime;
use Exception;
use Vendelev\Service\Example\Lib\HttpClient;
use Vendelev\Service\Example\Lib\Loggers\LoggerTrait;
use Vendelev\Service\Example\Lib\PinbaTrait;

class Service
{
    use LoggerTrait, PinbaTrait;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @param string $url
     *
     * @return array
     * @throws Exception
     */
    public function getDivisions($url)
    {
        $returnValue = [];

        if ($this->checkUrl($url)) {

            $timerName = 'Division';
            $this->timerStart($timerName, array('group' => 'request', 'operation' => 'get'));
            $request = $this->getHttpClient()->get($url);
            $timerInfo = ($this->getMonitoring()) ? $this->getMonitoring()->timerGetInfo($timerName) : [];
            $this->timerStop($timerName);

            if ($this->checkResponse($request->getStatusCode(), $request->getReasonPhrase())) {
                $this->getLogger()->info('Отправили запрос в сервис', ['url' => $url, 'timerInfo' => $timerInfo]);
                $json   = $request->getContents();
                $result = $request->jsonDecode($json);

                if ($this->checkJson($result) && $this->checkSatus($result)) {
                   $returnValue = $this->convertNameFields($result['divisions']);
                }
            }
        }

        return $returnValue;
    }

    /**
     * @param string $url
     *
     * @return bool
     * @throws Exception
     */
    public function checkUrl($url)
    {
        if (empty($url)) {
            throw new Exception('URL сервиса для получения отделов не заполнен', 400);
        }

        return true;
    }

    /**
     * @param int    $code
     * @param string $phrase
     *
     * @return bool
     * @throws Exception
     */
    public function checkResponse($code, $phrase)
    {
        if ($code != 200) {
            throw new Exception('Ответ сервиса: '. $phrase, $code);
        }

        return true;
    }

    /**
     * @param array $result
     *
     * @return bool
     * @throws Exception
     */
    public function checkJson(array $result)
    {
        if (empty($result['status'])) {
            throw new Exception('Не верный формат ответа сервиса', 405);
        }

        return true;
    }

    /**
     * @param array $result
     *
     * @return bool
     * @throws Exception
     */
    public function checkSatus(array $result)
    {
        if (strtoupper($result['status']) != 'OK') {
            throw new Exception('Статус ответа сервиса: ' . $result['status'], 406);
        }

        return true;
    }

    /**
     * @param array $divisions
     *
     * @return array
     *
     */
    public function convertNameFields(array $divisions)
    {
        $map = array(
            'divCode'       => 'CODE',
            'divFullName'   => 'FULLNAME',
            'divUpdated'    => 'UPDATED',
            'divIndex'      => 'POST_INDEX',
            'divAddr'       => 'ADDR',
            'divFiasId'     => 'FIAS_ID',
        );

        $returnValue = [];
        foreach ($divisions as $fields) {
            $tmp = [];
            foreach ($fields as $key => $value) {
                if (array_key_exists($key, $map)) {
                    $tmp[$map[$key]] = $value;
                }

                if ($key == 'divUpdated') {
                    $tmp['UPDATED'] = (new DateTime($value))->getTimestamp();
                }
            }
            if ($tmp) {
                $returnValue[$fields['divCode']] = $tmp;
            }
        }

        return $returnValue;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return $this
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }
}