<?php

namespace Vendelev\Service\Example\Lib;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Обертка для работы с библиотекой GuzzleHttp
 *
 * @package Vendelev\Service\Example\Lib
 */
class HttpClient
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param string $url
     *
     * @return $this
     */
    public function get($url)
    {
        $this->setClientResponse($this->getHttpClient()->get($url));

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->getClientResponse()->getStatusCode();
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->getClientResponse()->getBody()->getContents();
    }

    /**
     * @param string $json
     *
     * @return mixed
     * @throws \InvalidArgumentException if the JSON cannot be decoded.
     */
    public function jsonDecode($json)
    {
        return \GuzzleHttp\json_decode($json, true);
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->getClientResponse()->getReasonPhrase();
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client();
    }

    /**
     * @return ResponseInterface
     */
    protected function getClientResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return $this
     */
    protected function setClientResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }
}