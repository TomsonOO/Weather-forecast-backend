<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\OpenMeteo;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Weather\Infrastructure\Exception\ExternalApiException;

class OpenMeteoAdapter
{
    private HttpClientInterface $client;
    private string $baseUrl;

    public function __construct(HttpClientInterface $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function fetchWeeklyData(float $latitude, float $longitude): array
    {
        $response = $this->client->request('GET', $this->baseUrl.'/v1/forecast', [
            'query' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'weathercode,temperature_2m_min,temperature_2m_max,sunshine_duration',
                'timezone' => 'UTC',
            ],
        ]);

        return $this->parseResponse($response);
    }

    public function fetchWeeklySummaryData(float $latitude, float $longitude): array
    {
        $response = $this->client->request('GET', $this->baseUrl.'/v1/forecast', [
            'query' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'weathercode,temperature_2m_min,temperature_2m_max,sunshine_duration',
                'hourly' => 'surface_pressure',
                'timezone' => 'UTC',
            ],
        ]);

        $data = $this->parseResponse($response);

        if (!isset($data['daily']) || !isset($data['hourly'])) {
            throw new ExternalApiException('Invalid response structure from OpenMeteo API.');
        }

        return $data;
    }

    private function parseResponse($response): array
    {
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new ExternalApiException('Failed to fetch data from OpenMeteo API. Status code: '.$response->getStatusCode());
        }

        try {
            $data = $response->toArray();
        } catch (\Throwable $e) {
            throw new ExternalApiException('Failed to parse OpenMeteo API response.', 0, $e);
        }

        return $data;
    }
}
