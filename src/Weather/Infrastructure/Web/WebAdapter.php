<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Weather\Application\Get7DayForecast\Get7DayForecastQuery;
use App\Weather\Application\Get7DayForecast\Get7DayForecastQueryHandler;

class WebAdapter extends AbstractController
{
    private Get7DayForecastQueryHandler $get7DayForecastHandler;

    public function __construct(Get7DayForecastQueryHandler $get7DayForecastHandler)
    {
        $this->get7DayForecastHandler = $get7DayForecastHandler;
    }

    #[Route('/api/weather/forecast', name: 'weather_forecast', methods: ['GET'])]
    public function getWeeklyForecast(Request $request): JsonResponse
    {
        $latitude = (float)$request->query->get('latitude');
        $longitude = (float)$request->query->get('longitude');
        $query = new Get7DayForecastQuery($latitude, $longitude);
        $result = $this->get7DayForecastHandler->handle($query);
        return $this->json($result);
    }
}