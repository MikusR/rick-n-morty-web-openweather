<?php

namespace App;

use App\Models\Weather;
use GuzzleHttp\Client;

class WeatherApi
{

    private Client $client;
    private const WEATHER_API = 'https://api.openweathermap.org/data/2.5/weather?q=';


    public function __construct()
    {
        $this->client = new Client();
    }


    public function fetchWeather(string $city): Weather
    {
        $apikey = $_ENV['OPEN_WEATHER_API_KEY'];
        $response = $this->client->get(self::WEATHER_API . "$city" . '&appid=' . $apikey . "&units=metric");

        $data = json_decode((string)$response->getBody());
        return new Weather($data->name, $data->weather[0]->description, $data->main->temp, $data->timezone);
    }
}