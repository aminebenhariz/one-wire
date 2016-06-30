<?php

namespace AmineBenHariz\OneWire\Device;

use AmineBenHariz\OneWire\Exception\DeviceNotFoundException;
use AmineBenHariz\OneWire\Exception\InvalidDeviceNameException;

/**
 * Class DeviceAbstract
 * @package AmineBenHariz\OneWire\Device
 */
abstract class DeviceAbstract
{
    /**
     * example of valid device name: 28-000004bfae30
     *   - 28           : family code
     *   - 000004bfae30 : serial code
     */
    const W1_DEVICE_NAME_REGEX = '/^([0-9a-f]{2})-([0-9a-f]{12})$/';

    /**
     * @var string
     */
    protected $devicePath;

    /**
     * DeviceAbstract constructor.
     * @param string $devicePath
     * @throws DeviceNotFoundException
     * @throws InvalidDeviceNameException
     */
    public function __construct($devicePath)
    {
        if (!file_exists($devicePath)) {
            throw new DeviceNotFoundException("device path not found: " . $devicePath);
        }

        if (!preg_match(self::W1_DEVICE_NAME_REGEX, basename($devicePath))) {
            throw new InvalidDeviceNameException("invalid device name: " . basename($devicePath));
        }

        $this->devicePath = $devicePath;
    }

    /**
     * @return string
     */
    public function getDeviceName()
    {
        return basename($this->devicePath);
    }

    /**
     * @return string
     * @throws InvalidDeviceNameException
     */
    public function getFamilyCode()
    {
        return self::parseFamilyCode($this->getDeviceName());
    }

    /**
     * @return string
     * @throws InvalidDeviceNameException
     */
    public function getSerialCode()
    {
        return self::parseSerialCode($this->getDeviceName());
    }

    /**
     * @param string $deviceName
     * @return int
     */
    public static function isValidDeviceName($deviceName)
    {
        return preg_match(self::W1_DEVICE_NAME_REGEX, $deviceName);
    }

    /**
     * @param string $deviceName
     * @return string
     * @throws InvalidDeviceNameException
     */
    public static function parseFamilyCode($deviceName)
    {
        if (!preg_match(self::W1_DEVICE_NAME_REGEX, $deviceName, $parts)) {
            throw new InvalidDeviceNameException;
        }

        return $parts[1];
    }

    /**
     * @param string $deviceName
     * @return string
     * @throws InvalidDeviceNameException
     */
    public static function parseSerialCode($deviceName)
    {
        if (!preg_match(self::W1_DEVICE_NAME_REGEX, $deviceName, $parts)) {
            throw new InvalidDeviceNameException;
        }
        return $parts[2];
    }
}
