<?php

namespace App\Models;

class Weather
{
    private string $name;
    private string $description;
    private string $temperature;
    private string $timezone;

    public function __construct(string $name, string $description, string $temperature, string $timezone)
    {
        $this->name = $name;
        $this->description = $description;
        $this->temperature = $temperature;
        $this->timezone = $timezone / 3600;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function __toString(): string
    {
        return "It's {$this->getTemperature()}°C and {$this->getDescription()} in {$this->getName()}";
    }
}