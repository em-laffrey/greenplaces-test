<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Laravel Starter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="bg-[#0f4e43] text-[#d1fd98] p-4 flex items-center gap-4">
        <a class="flex items-center gap-2 text-lg" href="">
            <x-icons.globe-americas class="size-8" />
            Weather Dashboard
        </a>
        <div class="pl-12 space-x-4">
            <a href="" class="hover:text-white transition-colors">Home</a>
            <a href="https://google.com" class="hover:text-white transition-colors">Google</a>
        </div>
    </nav>
    <h1 class="text-2xl font-bold">Weather Dashboard</h1>

    <div>
        <p>Current Temperature: <span>XX</span></p>
        <p>Current Condition: Sunny</p>
    </div>
    <div>
        <h2>Additional Details</h2>
        <p>Humidity: <span>X%</span></p>
        <p>Wind Speed: <span>X</span></p>
    </div>
</body>
</html>