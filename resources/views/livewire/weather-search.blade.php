<div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
    <h1 class="text-2xl font-bold flex items-center gap-2 text-[#0f4e43] mb-6">
        <x-icons.sun class="size-8 text-amber-500" />Weather Search
    </h1>

    <div class="mb-6">
        <label for="selectedCity" class="block text-sm font-medium text-gray-700">Select City</label>
        <div class="relative">
            <select id="selectedCity" wire:model.live="selectedCity"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0f4e43] focus:ring-[#0f4e43]"
                wire:loading.class="opacity-50" wire:loading.attr="disabled">
                @foreach ($this->cities as $value => $city)
                    <option value="{{ $value }}">{{ $city['name'] }}</option>
                @endforeach
            </select>
            <div wire:loading class="absolute inset-y-0 right-0 flex items-center pr-8">
                <svg class="animate-spin h-5 w-5 text-[#0f4e43]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        @error('selectedCity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    @if ($error)
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
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
        <div class="space-y-4 divide-y divide-gray-100">
            @if (isset($weatherData['current_weather']))
                <div class="pb-4">
                    <p class="text-lg">Current Temperature: 
                        <span class="font-semibold text-[#0f4e43]">
                            {{ $weatherData['current_weather']['temperature'] }}°F
                        </span>
                    </p>
                    <p class="text-lg">Current Condition: 
                    <span class="font-semibold text-[#0f4e43]">
                    {{ \App\Services\WeatherService::getWeatherCondition($weatherData['current_weather']['weathercode']) }}
                        </span>
                    </p>
                </div>

                <div class="pt-4">
                    <h2 class="text-xl font-semibold text-[#0f4e43] mb-3">Additional Details</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600">Wind Speed: 
                            <span class="font-medium text-[#0f4e43]">
                                {{ $weatherData['current_weather']['windspeed'] }} mph
                            </span>
                        </p>
                        <p class="text-gray-600">Wind Direction: 
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
