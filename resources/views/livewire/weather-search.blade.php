<div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
    <h1 class="text-2xl font-bold flex items-center gap-2 text-[#0f4e43] mb-6">
        <x-icons.sun class="size-8 text-amber-500" aria-hidden="true" />Weather in your area
    </h1>

    <div class="mb-6">
        <label for="selectedCity" class="block text-sm font-medium text-gray-700">Select City</label>
        <div class="relative">
            <select id="selectedCity" wire:model.live="selectedCity"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0f4e43] focus:ring-[#0f4e43]"
                wire:loading.class="opacity-50" wire:loading.attr="disabled"
                aria-label="Choose a city to view weather information">
                @foreach ($this->cities as $value => $city)
                    <option value="{{ $value }}">{{ $city['name'] }}</option>
                @endforeach
            </select>
            <div wire:loading class="absolute inset-y-0 right-0 flex items-center pr-8" 
                 role="status" 
                 aria-label="Loading weather data">
                <x-icons.spinner class="h-5 w-5 text-[#0f4e43]" aria-hidden="true" />
            </div>
        </div>
        @error('selectedCity') <span class="text-red-500 text-sm" role="alert">{{ $message }}</span> @enderror
    </div>

    @if ($error)
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-4 mb-4" role="alert" aria-live="assertive">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-icons.exclamation class="h-5 w-5 text-red-400" aria-hidden="true" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <div class="mt-2 text-sm text-red-700">
                        {{ $error }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($weatherData)
        <div class="space-y-4 divide-y divide-gray-100" 
             role="region" 
             aria-label="Current weather conditions"
             aria-live="polite"
             aria-atomic="true">
            @if (isset($weatherData['current_weather']))
                <div class="pb-4">
                    <p class="text-lg" role="group" aria-label="Temperature information">
                        Current Temperature: 
                        <span class="font-semibold text-[#0f4e43]">
                            {{ $weatherData['current_weather']['temperature'] }}°F
                        </span>
                    </p>
                    <p class="text-lg" role="group" aria-label="Weather condition information">
                        Current Condition: 
                        <span class="font-semibold text-[#0f4e43]">
                            {{ \App\Services\WeatherService::getWeatherCondition($weatherData['current_weather']['weathercode']) }}
                        </span>
                    </p>
                </div>

                <div class="pt-4">
                    <h2 class="text-xl font-semibold text-[#0f4e43] mb-3">Additional Details</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600" role="group" aria-label="Wind speed information">
                            Wind Speed: 
                            <span class="font-medium text-[#0f4e43]">
                                {{ $weatherData['current_weather']['windspeed'] }} mph
                            </span>
                        </p>
                        <p class="text-gray-600" role="group" aria-label="Wind direction information">
                            Wind Direction: 
                            <span class="font-medium text-[#0f4e43]">
                                {{ $weatherData['current_weather']['winddirection'] }}°
                            </span>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
