<?php

declare(strict_types=1);

namespace App\Weather\Domain\Service;

class SolarEnergyCalculator
{
    private const INSTALLATION_POWER = 2.5;
    private const EFFICIENCY = 0.2;

    public function calculate(float $sunExposure): float
    {
        return self::INSTALLATION_POWER * $sunExposure * self::EFFICIENCY;
    }
}
