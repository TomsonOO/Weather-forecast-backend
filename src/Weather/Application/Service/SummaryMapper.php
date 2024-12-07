<?php

declare(strict_types=1);

namespace App\Weather\Application\Service;

use App\Weather\Application\DTO\WeeklySummaryDto;

class SummaryMapper
{
    public function map(array $data): WeeklySummaryDto
    {
        $dailyData = $data['daily'];
        $hourlyData = $data['hourly'];

        $minTemps = $dailyData['temperature_2m_min'];
        $maxTemps = $dailyData['temperature_2m_max'];
        $sun = $dailyData['sunshine_duration'];
        $codes = $dailyData['weathercode'];

        $hourlyPressure = $hourlyData['surface_pressure'];

        $countDays = count($minTemps);
        $avgSunExposure = array_sum($sun) / $countDays;

        $lowestTemp = min($minTemps);
        $highestTemp = max($maxTemps);

        $precipitationDays = 0;
        foreach ($codes as $code) {
            // kody 51+ oznaczają jakies opady
            if ($code >= 51) {
                ++$precipitationDays;
            }
        }

        $weatherSummary = ($precipitationDays >= 4) ? 'z opadami' : 'bez opadów';

        $countHours = count($hourlyPressure);
        $avgPressure = array_sum($hourlyPressure) / $countHours;

        return new WeeklySummaryDto(
            $avgPressure,
            $avgSunExposure,
            $lowestTemp,
            $highestTemp,
            $weatherSummary
        );
    }
}
