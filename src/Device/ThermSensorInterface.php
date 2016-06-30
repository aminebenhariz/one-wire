<?php

namespace AmineBenHariz\OneWire\Device;

/**
 * Interface TemperatureSensorInterface
 * @package AmineBenHariz\OneWire\Device
 */
interface ThermSensorInterface
{
    /**
     * @return float
     */
    public function readTemperatureCelsius();

    /**
     * @return float
     */
    public function readTemperatureFahrenheit();
}
