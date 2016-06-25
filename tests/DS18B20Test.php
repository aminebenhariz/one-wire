<?php

namespace AmineBenHariz\OneWire\Tests;

use AmineBenHariz\OneWire\DS18B20;

/**
 * Class DS18B20Test
 * @package AmineBenHariz\OneWire\Tests
 */
class DS18B20Test extends \PHPUnit_Framework_TestCase
{
    public function testGetTemperature()
    {
        $devicePath = __DIR__ . '/resources/28-000007102382';

        $sensor = new DS18B20($devicePath);

        $this->assertSame(27.750, $sensor->readTemperature());
    }
}
