<?php

namespace Vendelev\Service\Example\Lib;

/**
 * Обертка для работы с методами Pinba
 *
 * @package Vendelev\Service\Example\Lib
 */
class Pinba
{
    /**
     * @var Pinba
     */
    private static $instance;

    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * @var array
     */
    private $timers = array();

    /**
     * @return Pinba
     **/
    public static function me()
    {
        if (empty(self::$instance)) {
            self::$instance = new Pinba();
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @param string $name Внутреннее имя, не передается на сервер Pinbaю Требуется для остановки и удаления timer
     * @param array $tags
     *
     * @return $this
     * @throws \Exception
     */
    public function timerStart($name, array $tags)
    {
        if (array_key_exists($name, $this->getTimers())) {
            throw new \Exception('Такой timer уже существет: '. $name);
        }

        if ($this->getEnabled()) {
            $this->setTimer($name, pinba_timer_start($tags));
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function timerStop($name)
    {
        if ($this->getEnabled()) {
            pinba_timer_stop($this->getTimer($name));
        }

        $this->unsetTimer($name);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function timerDelete($name)
    {
        if ($this->getEnabled()) {
            pinba_timer_delete($this->getTimer($name));
        }

        $this->unsetTimer($name);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function timerGetInfo($name)
    {
        if ($this->getEnabled()) {
            return pinba_timer_get_info($this->getTimer($name));
        } else {
            return [];
        }
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setScriptName($name)
    {
        if ($this->getEnabled()) {
            pinba_script_name_set($name);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setServerName($name)
    {
        if ($this->getEnabled()) {
            pinba_server_name_set($name);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setHostName($name)
    {
        if ($this->getEnabled()) {
            pinba_hostname_set($name);
        }

        return $this;
    }

    /**
     * Ручная запись данных
     *
     * @return $this
     */
    public function flush()
    {
        if ($this->getEnabled()) {
            pinba_flush();
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function getTimers()
    {
        return $this->timers;
    }

    /**
     * @param string $name
     *
     * @return resource
     * @throws \Exception
     */
    protected function getTimer($name)
    {
        if (!array_key_exists($name, $this->getTimers())) {
            throw new \Exception('Timer не найден: ' . $name);
        }

        return $this->timers[$name];
    }

    /**
     * @param string $name
     * @param resource $value
     */
    protected function setTimer($name, $value)
    {
        $this->timers[$name] = $value;
    }

    protected function unsetTimer($name)
    {
        unset($this->timers[$name]);
    }
}