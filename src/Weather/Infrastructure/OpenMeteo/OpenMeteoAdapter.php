<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\OpenMeteo;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenMeteoAdapter
{
    private HttpClientInterface $client;
    private string $baseUrl;

    public function __construct(HttpClientInterface $client, string $baseUrl = 'https://api.open-meteo.com')
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function fetchWeeklyData(float $latitude, float $longitude): array
    {
        $response = $this->client->request('GET', $this->baseUrl . '/v1/forecast', [
            'query' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'weathercode,temperature_2m_min,temperature_2m_max,sunshine_duration',
                'timezone' => 'UTC'
            ]
        ]);

        return $response->toArray();
    }
}