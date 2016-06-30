<?php

namespace AmineBenHariz\OneWire;

use AmineBenHariz\OneWire\Device\DeviceAbstract;
use AmineBenHariz\OneWire\Device\ThermSensorInterface;

/**
 * Class DeviceScanner
 * @package AmineBenHariz\OneWire
 */
class DeviceScanner
{
    const DEFAULT_W1_PATH = '/sys/bus/w1/devices/';

    /**
     * @param string|null $path
     * @return ThermSensorInterface[]
     */
    public static function scanAllTemperatureSensors($path = null)
    {
        if (is_null($path)) {
            $path = self::DEFAULT_W1_PATH;
        }

        $path = rtrim($path, '/') . '/';

        $files = scandir($path);

        $deviceFactory = new ThermSensorFactory();

        $sensors = [];

        foreach ($files as $file) {
            // we are interested in directories only
            if (!is_dir($path . $file)) {
                continue;
            }

            // filter out invalid 1-wire directories
            if (!DeviceAbstract::isValidDeviceName($file)) {
                continue;
            }

            // filter out non thermSensor devices
            $familyCode = DeviceAbstract::parseFamilyCode($file);
            if (!array_key_exists($familyCode, $deviceFactory->getThermSensorList())) {
                continue;
            }

            $sensors[] = $deviceFactory->createThermSensor($path . $file);
        }

        return $sensors;
    }
}
