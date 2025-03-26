<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Laravel Starter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen">
    <nav class="bg-[#0f4e43] text-[#d1fd98] relative">

        <!-- Desktop Navigation -->
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a class="flex items-center gap-2 text-lg" href="">
                    <x-icons.globe-americas class="size-8" />
                    Weather Dashboard
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="" class="hover:text-white transition-colors">Home</a>
                    <a href="https://google.com" class="hover:text-white transition-colors">Google</a>
                </div>

                <!-- Mobile Menu -->
                <div class="md:hidden">
                    <button onclick="toggleMenu()" class="text-[#d1fd98] hover:text-white transition-colors">
                        <x-icons.bars-3 id="menu-open" class="w-8 h-8" />
                        <x-icons.x-mark id="menu-close" class="w-8 h-8 hidden" />
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu"
            class="hidden md:hidden absolute inset-x-0 top-16 bg-[#0f4e43] border-t border-[#d1fd98]/20 transition-all duration-200 opacity-0 -translate-y-4">
            <div class="px-4 py-3 space-y-3">
                <a href="" class="block hover:text-white transition-colors">Home</a>
                <a href="https://google.com" class="block hover:text-white transition-colors">Google</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 flex justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
            <h1 class="text-2xl font-bold flex items-center gap-2 text-[#0f4e43] mb-6">
                <x-icons.sun class="size-8 text-amber-500" />Weather Forecast
            </h1>
            <div id="weather-data" class="text-gray-600">
                <div class="animate-pulse">
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                </div>
            </div>
            <div id="error-message" class="mt-4 text-red-600 hidden"></div>
        </div>
    </main>

    <footer class="bg-[#0f4e43] text-[#d1fd98] py-4">
        <div class="container mx-auto px-4 text-center flex justify-center gap-4">
            <x-icons.linkedin class="w-6 h-6 text-[#d1fd98]" />
            <x-icons.youtube class="w-6 h-6 text-[#d1fd98]" />
            <x-icons.spotify class="w-6 h-6 text-[#d1fd98]" />
            <p>&copy; {{ date('Y') }} Weather Dashboard. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOpen = document.getElementById('menu-open');
            const menuClose = document.getElementById('menu-close');

            if (mobileMenu.classList.contains('hidden')) {
                // Show menu
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0', '-translate-y-4');
                }, 10);
                menuOpen.classList.add('hidden');
                menuClose.classList.remove('hidden');
            } else {
                // Hide menu
                mobileMenu.classList.add('opacity-0', '-translate-y-4');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 200);
                menuOpen.classList.remove('hidden');
                menuClose.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
                const dataDiv = document.getElementById('weather-data');
                const errorDiv = document.getElementById('error-message');

                try {
                    const response = await fetch('/api/weather');
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to fetch weather data');
                    }
                    
                    let html = '<div class="space-y-4">';
                    
                    if (data.current) {
                        const temp = data.current.temperature_2m;
                        const humidity = data.current.relative_humidity_2m;
                        const windSpeed = data.current.wind_speed_10m;
                        const weatherCode = data.current.weather_code;

                        html += `
                            <div class="space-y-4 divide-y divide-gray-100">
                                <div class="pb-4">
                                    <p class="text-lg">Current Temperature: <span class="font-semibold text-[#0f4e43]">${temp}°</span></p>
                                    <p class="text-gray-600">Current Condition: <span class="text-[#0f4e43]">${weatherCode}</span></p>
                                </div>
                                <div class="pt-4">
                                    <h2 class="text-xl font-semibold text-[#0f4e43] mb-3">Additional Details</h2>
                                    <p class="text-lg">Humidity: <span class="font-semibold text-[#0f4e43]">${humidity}%</span></p>
                                    <p class="text-gray-600">Wind Speed: <span class="font-semibold text-[#0f4e43]">${windSpeed} mph</span></p>
                                </div>
                            </div>
                            `;
                    } else {
                        html += '<p>No weather data available</p>';
                    }
                    
                    html += '</div>';
                    dataDiv.innerHTML = html;
                } catch (error) {
                    errorDiv.classList.remove('hidden');
                    errorDiv.textContent = error.message;
                    dataDiv.innerHTML = '<p class="text-gray-500">Failed to load weather data</p>';
                }
            });
    </script>
</body>
</html>
