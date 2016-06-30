<?php

namespace AmineBenHariz\OneWire\Tests\Device;

use AmineBenHariz\OneWire\Device\DS18B20;

/**
 * Class DS18B20Test
 * @package AmineBenHariz\OneWire\Tests\Device
 */
class DS18B20Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DS18B20
     */
    public function testValidSensorCreation()
    {
        $devicePath = __DIR__ . '/../resources/valid_response/28-000007102382';

        $sensor = new DS18B20($devicePath);
        $this->assertInstanceOf('\AmineBenHariz\OneWire\Device\DS18B20', $sensor);

        return $sensor;
    }

    /**
     * @expectedException \AmineBenHariz\OneWire\Exception\DeviceNotFoundException
     */
    public function testDeviceNotFoundException()
    {
        $devicePath = __DIR__ . '/../resources/device_not_found/28-000007102382';

        new DS18B20($devicePath);
    }

    /**
     * @expectedException \AmineBenHariz\OneWire\Exception\InvalidDeviceResponseException
     */
    public function testInvalidDeviceResponse()
    {
        $devicePath = __DIR__ . '/../resources/invalid_response/28-000007102382';

        $sensor = new DS18B20($devicePath);
        $this->assertInstanceOf('\AmineBenHariz\OneWire\Device\DS18B20', $sensor);

        $sensor->readTemperatureCelsius();
    }

    /**
     * @depends testValidSensorCreation
     *
     * @param DS18B20 $sensor
     */
    public function testReadTemperatureCelsius(DS18B20 $sensor)
    {
        $this->assertSame(27.750, $sensor->readTemperatureCelsius());
    }

    /**
     * @depends testValidSensorCreation
     *
     * @param DS18B20 $sensor
     */
    public function testReadTemperatureFahrenheit(DS18B20 $sensor)
    {
        // 27.750 C <==> 81.95 F
        $this->assertSame(81.95, $sensor->readTemperatureFahrenheit());
    }
}
