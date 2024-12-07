<?php

declare(strict_types=1);

namespace App\Weather\Application\DTO;

class DailyForecastDto
{
    public string $date;
    public int $weatherCode;
    public float $minTemp;
    public float $maxTemp;
    public float $generatedEnergy;

    public function __construct(string $date, int $weatherCode, float $minTemp, float $maxTemp, float $generatedEnergy)
    {
        $this->date = $date;
        $this->weatherCode = $weatherCode;
        $this->minTemp = $minTemp;
        $this->maxTemp = $maxTemp;
        $this->generatedEnergy = $generatedEnergy;
    }
}