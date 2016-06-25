<?php

namespace AmineBenHariz\OneWire;

/**
 * Class DS18B20
 * @package AmineBenHariz\OneWire
 */
class DS18B20
{
    /**
     * @var string
     */
    private $devicePath;

    /**
     * DS18B20 constructor.
     * @param string $devicePath
     */
    public function __construct($devicePath)
    {
        $this->devicePath = $devicePath;
    }

    /**
     * @return int
     */
    private function readRawTemperature()
    {
        $content = file_get_contents($this->devicePath . '/w1_slave');
        preg_match('/t=(\d+)/', $content, $parts);

        return intval($parts[1]);
    }

    /**
     * @return float
     */
    public function readTemperature()
    {
        $rawTemperature = $this->readRawTemperature();

        return $rawTemperature / 1000;
    }
}
