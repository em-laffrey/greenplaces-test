<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\Attributes\Rule;

class WeatherSearch extends Component
{
    #[Rule('required|string')]
    public $selectedCity = 'charlotte'; // Default to Charlotte

    public $weatherData = null;
    public $error = null;

    private $cities = [
        'atlanta' => ['name' => 'Atlanta, GA', 'lat' => 33.75, 'lon' => -84.39],
        'boston' => ['name' => 'Boston, MA', 'lat' => 42.36, 'lon' => -71.06],
        'charlotte' => ['name' => 'Charlotte, NC', 'lat' => 35.22, 'lon' => -80.85],
        'chicago' => ['name' => 'Chicago, IL', 'lat' => 41.88, 'lon' => -87.63],
        'dallas' => ['name' => 'Dallas, TX', 'lat' => 32.78, 'lon' => -96.80],
        'denver' => ['name' => 'Denver, CO', 'lat' => 39.74, 'lon' => -104.99],
        'houston' => ['name' => 'Houston, TX', 'lat' => 29.76, 'lon' => -95.37],
        'los_angeles' => ['name' => 'Los Angeles, CA', 'lat' => 34.05, 'lon' => -118.24],
        'miami' => ['name' => 'Miami, FL', 'lat' => 25.77, 'lon' => -80.19],
        'new_york' => ['name' => 'New York, NY', 'lat' => 40.71, 'lon' => -74.01],
        'phoenix' => ['name' => 'Phoenix, AZ', 'lat' => 33.45, 'lon' => -112.07],
        'san_francisco' => ['name' => 'San Francisco, CA', 'lat' => 37.77, 'lon' => -122.42],
        'seattle' => ['name' => 'Seattle, WA', 'lat' => 47.61, 'lon' => -122.33],
    ];

    private ApiService $apiService;

    public function boot()
    {
        $this->apiService = app(ApiService::class);
    }

    public function mount()
    {
        $this->search(); // Load initial weather data
    }

    public function getCitiesProperty()
    {
        return $this->cities;
    }

    public function updatedSelectedCity()
    {
        $this->search();
    }

    public function search()
    {
        $this->error = null;
        $this->weatherData = null;

        try {
            if (!isset($this->cities[$this->selectedCity])) {
                throw new \Exception('Invalid city selected');
            }

            $city = $this->cities[$this->selectedCity];
            $params = [
                'latitude' => $city['lat'],
                'longitude' => $city['lon'],
                'wind_speed_unit' => 'mph',
                'temperature_unit' => 'fahrenheit',
                'precipitation_unit' => 'inch',
                'hourly' => 'temperature_2m',
                'current_weather' => true,
                'current' => ['temperature_2m','relative_humidity_2m','weather_code','wind_speed_10m']
            ];

            logger()->info('Weather API request', ['params' => $params]);
            $this->weatherData = $this->apiService->get('forecast', $params);
            logger()->info('Weather API response', ['data' => $this->weatherData]);

            if (!isset($this->weatherData['current_weather'])) {
                throw new \Exception('Invalid response format from weather API');
            }
        } catch (\Exception $e) {
            logger()->error('Weather API error', [
                'city' => $this->selectedCity,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error = 'Failed to fetch weather data. Please try again later.';
        }
    }

    public function render()
    {
        return view('livewire.weather-search');
    }
}
