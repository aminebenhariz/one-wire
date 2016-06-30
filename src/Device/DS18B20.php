<?php

namespace AmineBenHariz\OneWire\Device;

use AmineBenHariz\OneWire\Exception\InvalidDeviceNameException;
use AmineBenHariz\OneWire\Exception\InvalidDeviceResponseException;

/**
 * Class DS18B20
 * @package AmineBenHariz\OneWire\Device
 */
class DS18B20 extends ThermSensorAbstract
{
    const FAMILY_CODE = '28';

    /**
     * DS18B20 constructor.
     * @param string $devicePath
     * @throws \Exception
     */
    public function __construct($devicePath)
    {
        parent::__construct($devicePath);

        if ($this->getFamilyCode() != self::FAMILY_CODE) {
            throw new InvalidDeviceNameException('invalid DS18B20 device name: ' . $this->getDeviceName());
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getSlaveFileContent()
    {
        if (!file_exists($this->devicePath . '/w1_slave')) {
            throw new \Exception("slave file not found");
        }

        $content = file_get_contents($this->devicePath . '/w1_slave');
        return $content;
    }

    /**
     * @return int
     * @throws InvalidDeviceResponseException
     */
    private function readTemperatureRaw()
    {
        $content = $this->getSlaveFileContent();

        if (!preg_match('/crc=[0-9a-f]{2} YES/', $content)) {
            throw new InvalidDeviceResponseException;
        }

        preg_match('/t=(\d+)/', $content, $parts);

        return intval($parts[1]);
    }

    /**
     * @return float
     * @throws InvalidDeviceResponseException
     */
    public function readTemperatureCelsius()
    {
        $rawTemperature = $this->readTemperatureRaw();
        return round($rawTemperature / 1000, 3);
    }

    /**
     * @return float
     */
    public function readTemperatureFahrenheit()
    {
        $celsiusTemperature = $this->readTemperatureCelsius();
        return round(($celsiusTemperature * 1.8) + 32, 3);
    }
}
