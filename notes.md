# Weather Dashboard Notes

## Project Overview
A Laravel-based weather dashboard that displays current weather conditions and more for a list of major US cities using the Open Meteo API.

## Key Components

### 1. Weather Search Functionality (Livewire)
- Located in `app/Livewire/WeatherSearch.php`
- Uses Livewire for real-time updates
- Located in `resources/views/livewire/weather-search.blade.php`, features include:
  - City selection dropdown for major US cities
  - Live weather update when city is selected
  - Loading states with spinner
  - Error handling

### 2. Services
- **ApiService** (`app/Services/ApiService.php`):
  - Handles HTTP requests
  - Configured in `app/Providers/AppServiceProvider.php`
    - Base URL: https://api.open-meteo.com/v1

- **WeatherService** (`app/Services/WeatherService.php`):
  - Maps weather codes to human-readable conditions as Open Meteo uses numeric codes

### 3. Testing
- Uses PHPUnit:
  - WeatherSearchTest.php
  - ApiServiceTest.php
  - WeatherServiceTest.php

## UI/UX Features
- Responsive design with top navigation mobile menu and footer (located in `resources/views/welcome.blade.php`)
- Color scheme - same as GreenPlaces :):
  - Primary: #0f4e43 (dark green)
  - Accent: #d1fd98 (light green)
- Loading indicators
- Error messages
- Accessible components

## Additional Notes
When initializing the application for the first time, you will need to run the following commands:

```
touch database/database.sqlite
```

```
php artisan migrate
```