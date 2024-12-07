<?php

declare(strict_types=1);

namespace App\Weather\Application\Get7DayForecast;

use App\Weather\Application\DTO\DailyForecastDto;
use App\Weather\Application\Service\ForecastMapper;
use App\Weather\Domain\Service\SolarEnergyCalculator;
use App\Weather\Infrastructure\OpenMeteo\OpenMeteoAdapter;

class Get7DayForecastQueryHandler
{
    private OpenMeteoAdapter $adapter;
    private SolarEnergyCalculator $calculator;
    private ForecastMapper $mapper;

    public function __construct(OpenMeteoAdapter $adapter, SolarEnergyCalculator $calculator, ForecastMapper $mapper)
    {
        $this->adapter = $adapter;
        $this->calculator = $calculator;
        $this->mapper = $mapper;
    }

    public function handle(Get7DayForecastQuery $query): array
    {
        $rawData = $this->adapter->fetchWeeklyData($query->latitude(), $query->longitude());
        $forecasts = $this->mapper->map($rawData, $this->calculator);
        $dtoList = [];
        foreach ($forecasts as $forecast) {
            $dtoList[] = new DailyForecastDto(
                $forecast->date()->format('Y-m-d'),
                $forecast->weatherCode(),
                $forecast->minTemp(),
                $forecast->maxTemp(),
                $forecast->generatedEnergy()
            );
        }

        return $dtoList;
    }
}
