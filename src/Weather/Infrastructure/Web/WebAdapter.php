<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\Web;

use App\Weather\Application\GetWeeklySummary\GetWeeklySummaryQuery;
use App\Weather\Application\GetWeeklySummary\GetWeeklySummaryQueryHandler;
use App\Weather\Application\Get7DayForecast\Get7DayForecastQuery;
use App\Weather\Application\Get7DayForecast\Get7DayForecastQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/weather')]
class WebAdapter extends AbstractController
{
    private Get7DayForecastQueryHandler $get7DayForecastHandler;
    private GetWeeklySummaryQueryHandler $getWeeklySummaryHandler;

    public function __construct(
        Get7DayForecastQueryHandler $get7DayForecastHandler,
        GetWeeklySummaryQueryHandler $getWeeklySummaryQueryHandler,
    ) {
        $this->get7DayForecastHandler = $get7DayForecastHandler;
        $this->getWeeklySummaryHandler = $getWeeklySummaryQueryHandler;
    }

    #[Route('/forecast', name: 'weather_forecast', methods: ['GET'])]
    public function getWeeklyForecast(Request $request): JsonResponse
    {
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');

        $validationError = $this->validateCoordinates($latitude, $longitude);
        if (null !== $validationError) {
            return $this->json(['error' => $validationError], Response::HTTP_BAD_REQUEST);
        }

        $query = new Get7DayForecastQuery((float) $latitude, (float) $longitude);
        $result = $this->get7DayForecastHandler->handle($query);

        return $this->json($result, Response::HTTP_OK);
    }

    #[Route('/summary', name: 'weather_summary', methods: ['GET'])]
    public function getWeeklySummary(Request $request): JsonResponse
    {
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');

        $validationError = $this->validateCoordinates($latitude, $longitude);
        if (null !== $validationError) {
            return $this->json(['error' => $validationError], Response::HTTP_BAD_REQUEST);
        }

        $query = new GetWeeklySummaryQuery((float) $latitude, (float) $longitude);
        $result = $this->getWeeklySummaryHandler->handle($query);

        return $this->json($result, Response::HTTP_OK);
    }

    private function validateCoordinates(?string $latitude, ?string $longitude): ?string
    {
        if (null === $latitude || null === $longitude) {
            return 'Both latitude and longitude must be provided.';
        }

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return 'Latitude and longitude must be numeric.';
        }

        $lat = (float) $latitude;
        $lon = (float) $longitude;

        if ($lat < -90 || $lat > 90) {
            return 'Latitude must be between -90 and 90.';
        }

        if ($lon < -180 || $lon > 180) {
            return 'Longitude must be between -180 and 180.';
        }

        return null;
    }
}
