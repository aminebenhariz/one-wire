<?php

namespace AmineBenHariz\OneWire;

use AmineBenHariz\OneWire\Device\DeviceAbstract;
use AmineBenHariz\OneWire\Device\ThermSensorInterface;

/**
 * Class DeviceFactory
 * @package AmineBenHariz\OneWire
 */
class ThermSensorFactory
{
    /**
     * @var array
     */
    protected $thermSensorList;

    /**
     * DeviceFactory constructor.
     */
    public function __construct()
    {
        $this->thermSensorList = [
            '28' => __NAMESPACE__.'\Device\DS18B20',
        ];
    }

    /**
     * @return array
     */
    public function getThermSensorList()
    {
        return $this->thermSensorList;
    }

    /**
     * @param string $devicePath
     * @return ThermSensorInterface
     */
    public function createThermSensor($devicePath)
    {
        $sensorFamily = DeviceAbstract::parseFamilyCode(basename($devicePath));

        if (!array_key_exists($sensorFamily, $this->thermSensorList)) {
            throw new \InvalidArgumentException($sensorFamily . " family is not supported");
        }
        $className = $this->thermSensorList[$sensorFamily];

        return new $className($devicePath);
    }
}
