<?php

declare(strict_types=1);

namespace App\Weather\Domain\Model;

class DailyForecast
{
    private \DateTimeInterface $date;
    private int $weatherCode;
    private float $minTemp;
    private float $maxTemp;
    private float $sunExposure;
    private float $generatedEnergy;

    public function __construct(\DateTimeInterface $date, int $weatherCode, float $minTemp, float $maxTemp, float $sunExposure, float $generatedEnergy)
    {
        $this->date = $date;
        $this->weatherCode = $weatherCode;
        $this->minTemp = $minTemp;
        $this->maxTemp = $maxTemp;
        $this->sunExposure = $sunExposure;
        $this->generatedEnergy = $generatedEnergy;
    }

    public function date(): \DateTimeInterface
    {
        return $this->date;
    }

    public function weatherCode(): int
    {
        return $this->weatherCode;
    }

    public function minTemp(): float
    {
        return $this->minTemp;
    }

    public function maxTemp(): float
    {
        return $this->maxTemp;
    }

    public function sunExposure(): float
    {
        return $this->sunExposure;
    }

    public function generatedEnergy(): float
    {
        return $this->generatedEnergy;
    }
}
