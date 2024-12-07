<?php

declare(strict_types=1);

namespace App\Weather\Application\DTO;

class WeeklySummaryDto
{
    public float $averagePressure;
    public float $averageSunExposure;
    public float $lowestTemperature;
    public float $highestTemperature;
    public string $weatherSummary;

    public function __construct(
        float $averagePressure,
        float $averageSunExposure,
        float $lowestTemperature,
        float $highestTemperature,
        string $weatherSummary,
    ) {
        $this->averagePressure = $averagePressure;
        $this->averageSunExposure = $averageSunExposure;
        $this->lowestTemperature = $lowestTemperature;
        $this->highestTemperature = $highestTemperature;
        $this->weatherSummary = $weatherSummary;
    }
}
