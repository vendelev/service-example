<?php

namespace Vendelev\Service\Example\Lib\Loggers;

trait LoggerTrait
{
    /**
     * @var int Id текущего процесса
     */
    protected $pid = 0;

    /**
     * @var \Vendelev\Service\Example\Lib\Loggers\BaseLogger
     */
    protected $logger = null;

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     *
     * @return $this
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * @param \Vendelev\Service\Example\Lib\BaseLogger $logger
     *
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return \Vendelev\Service\Example\Lib\Loggers\BaseLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param string $text
     * @param array $context
     * @param string $level Уровень ошибки
     *
     * @return $this
     */
    public function log($text, array $context=array(), $level = 'debug')
    {
        $logger = $this->getLogger();

        if ($logger) {
            $logger->{$level}($text, array_merge($this->getExtLogData(), $context));
        }

        return $this;
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function debug($message, array $context = array())
    {
        return $this->log($message, $context, 'debug');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function info($message, array $context = array())
    {
        return $this->log($message, $context, 'info');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function notice($message, array $context = array())
    {
        return $this->log($message, $context, 'notice');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function warning($message, array $context = array())
    {
        return $this->log($message, $context, 'warning');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function error($message, array $context = array())
    {
        return $this->log($message, $context, 'error');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function critical($message, array $context = array())
    {
        return $this->log($message, $context, 'critical');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function alert($message, array $context = array())
    {
        return $this->log($message, $context, 'alert');
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function emergency($message, array $context = array())
    {
        return $this->log($message, $context, 'emergency');
    }

    /**
     * @return array
     */
    protected function getExtLogData()
    {
        return array(
            'pid' => $this->getPid(),
        );
    }

}