<?php

namespace AmineBenHariz\OneWire\Tests;

use AmineBenHariz\OneWire\DeviceScanner;

/**
 * Class DeviceScannerTest
 * @package AmineBenHariz\OneWire\Tests
 */
class DeviceScannerTest extends \PHPUnit_Framework_TestCase
{

    public function testScanAllTemperatureSensors()
    {
        $sensors = DeviceScanner::scanAllTemperatureSensors(__DIR__ . '/resources/valid_response');

        $this->assertCount(2, $sensors);
    }
}
