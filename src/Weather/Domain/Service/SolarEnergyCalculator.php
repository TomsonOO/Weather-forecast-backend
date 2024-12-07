<?php

declare(strict_types=1);

namespace App\Weather\Domain\Service;

class SolarEnergyCalculator
{
    private float $installationPower;
    private float $efficiency;

    public function __construct(float $installationPower, float $efficiency)
    {
        $this->installationPower = $installationPower;
        $this->efficiency = $efficiency;
    }

    public function calculate(float $sunExposure): float
    {
        return $this->installationPower * $sunExposure * $this->efficiency;
    }
}
