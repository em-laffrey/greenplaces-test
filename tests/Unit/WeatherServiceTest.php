<?php

namespace Tests\Unit;

use App\Services\WeatherService;
use PHPUnit\Framework\TestCase;

class WeatherServiceTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_correct_weather_condition_for_known_code()
    {
        $this->assertEquals('Clear sky', WeatherService::getWeatherCondition(0));
        $this->assertEquals('Partly cloudy', WeatherService::getWeatherCondition(2));
        $this->assertEquals('Moderate rain', WeatherService::getWeatherCondition(63));
        $this->assertEquals('Thunderstorm', WeatherService::getWeatherCondition(95));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_unknown_for_invalid_weather_code()
    {
        $this->assertEquals('Unknown', WeatherService::getWeatherCondition(999));
    }
}
