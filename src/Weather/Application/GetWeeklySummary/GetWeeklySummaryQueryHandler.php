<?php

declare(strict_types=1);

namespace App\Weather\Application\GetWeeklySummary;

use App\Weather\Application\DTO\WeeklySummaryDto;
use App\Weather\Application\Service\SummaryMapper;
use App\Weather\Infrastructure\OpenMeteo\OpenMeteoAdapter;

class GetWeeklySummaryQueryHandler
{
    private OpenMeteoAdapter $openMeteoAdapter;
    private SummaryMapper $summaryMapper;

    public function __construct(OpenMeteoAdapter $openMeteoAdapter, SummaryMapper $summaryMapper)
    {
        $this->openMeteoAdapter = $openMeteoAdapter;
        $this->summaryMapper = $summaryMapper;
    }

    public function handle(GetWeeklySummaryQuery $query): WeeklySummaryDto
    {
        $rawData = $this->openMeteoAdapter->fetchWeeklySummaryData($query->latitude(), $query->longitude());

        return $this->summaryMapper->map($rawData);
    }
}
