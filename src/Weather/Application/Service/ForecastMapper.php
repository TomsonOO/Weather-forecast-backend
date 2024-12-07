<?php

declare(strict_types=1);

namespace App\Weather\Application\Service;

use App\Weather\Domain\Model\DailyForecast;
use App\Weather\Domain\Service\SolarEnergyCalculator;

class ForecastMapper
{
    public function map(array $data, SolarEnergyCalculator $calculator): array
    {
        $forecasts = [];
        $dates = $data['daily']['time'];
        $minTemps = $data['daily']['temperature_2m_min'];
        $maxTemps = $data['daily']['temperature_2m_max'];
        $codes = $data['daily']['weathercode'];
        $sun = $data['daily']['sunshine_duration'];

        for ($i = 0; $i < count($dates); ++$i) {
            $date = new \DateTimeImmutable($dates[$i]);
            $energy = $calculator->calculate($sun[$i]);
            $forecasts[] = new DailyForecast(
                $date,
                (int) $codes[$i],
                (float) $minTemps[$i],
                (float) $maxTemps[$i],
                (float) $sun[$i],
                (float) $energy
            );
        }

        return $forecasts;
    }
}
