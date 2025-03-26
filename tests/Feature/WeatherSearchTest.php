<?php

namespace Tests\Feature;

use App\Livewire\WeatherSearch;
use App\Services\ApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WeatherSearchTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_weather_search_component()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeLivewire('weather-search');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_city_dropdown_with_options()
    {
        Livewire::test(WeatherSearch::class)
            ->assertSee('Charlotte, NC')
            ->assertSee('New York, NY')
            ->assertSee('Los Angeles, CA');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_fetches_weather_data_when_city_is_selected()
    {
        $this->mock(ApiService::class)
            ->shouldReceive('get')
            ->with('forecast', \Mockery::on(function ($params) {
                return isset($params['latitude']) 
                    && isset($params['longitude'])
                    && $params['wind_speed_unit'] === 'mph'
                    && $params['temperature_unit'] === 'fahrenheit';
            }))
            ->andReturn([
                'current_weather' => [
                    'temperature' => 72.5,
                    'weathercode' => 0,
                    'windspeed' => 5.2,
                    'winddirection' => 180
                ]
            ]);

        Livewire::test(WeatherSearch::class)
            ->set('selectedCity', 'charlotte')
            ->assertSee('72.5°F')
            ->assertSee('Clear sky')
            ->assertSee('5.2 mph');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_error_message_when_api_fails()
    {
        $this->mock(ApiService::class)
            ->shouldReceive('get')
            ->andThrow(new \RuntimeException('API Error'));

        Livewire::test(WeatherSearch::class)
            ->set('selectedCity', 'charlotte')
            ->assertSee('Failed to fetch weather data');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_loading_state_while_fetching_weather()
    {
        $this->mock(ApiService::class)
            ->shouldReceive('get')
            ->andReturn([
                'current_weather' => [
                    'temperature' => 70,
                    'weathercode' => 0,
                    'windspeed' => 5,
                    'winddirection' => 180
                ]
            ]);

        Livewire::test(WeatherSearch::class)
            ->set('selectedCity', 'charlotte')
            ->assertHasNoErrors()
            ->assertSee('wire:loading');
    }
}
