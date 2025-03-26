<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Laravel Starter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen">
    <nav class="bg-[#0f4e43] text-[#d1fd98] relative" role="navigation" aria-label="Main navigation">

        <!-- Desktop Navigation -->
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a class="flex items-center gap-2 text-lg" href="" aria-label="Weather Dashboard Home">
                    <x-icons.globe-americas class="size-8" aria-hidden="true" />
                    Weather Dashboard
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="" class="hover:text-white transition-colors" aria-label="Home page">Home</a>
                    <a href="https://google.com" class="hover:text-white transition-colors" aria-label="Visit Google">Google</a>
                </div>

                <!-- Mobile Menu -->
                <div class="md:hidden">
                    <button onclick="toggleMenu()" class="text-[#d1fd98] hover:text-white transition-colors" 
                            aria-expanded="false" 
                            aria-controls="mobile-menu" 
                            aria-label="Toggle navigation menu">
                        <x-icons.bars-3 id="menu-open" class="w-8 h-8" aria-hidden="true" />
                        <x-icons.x-mark id="menu-close" class="w-8 h-8 hidden" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu"
            class="hidden md:hidden absolute inset-x-0 top-16 bg-[#0f4e43] border-t border-[#d1fd98]/20 transition-all duration-200 opacity-0 -translate-y-4"
            role="menu" 
            aria-label="Mobile navigation menu">
            <div class="px-4 py-3 space-y-3">
                <a href="" class="block hover:text-white transition-colors" role="menuitem">Home</a>
                <a href="https://google.com" class="block hover:text-white transition-colors" role="menuitem">Google</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 flex justify-center" role="main">
        <livewire:weather-search />
    </main>

    <footer class="bg-[#0f4e43] text-[#d1fd98] py-4" role="contentinfo">
        <div class="container mx-auto px-4 text-center flex justify-center gap-4">
            <a href="#" aria-label="Visit our LinkedIn page">
                <x-icons.linkedin class="w-6 h-6 text-[#d1fd98]" aria-hidden="true" />
            </a>
            <a href="#" aria-label="Visit our YouTube channel">
                <x-icons.youtube class="w-6 h-6 text-[#d1fd98]" aria-hidden="true" />
            </a>
            <a href="#" aria-label="Visit our Spotify page">
                <x-icons.spotify class="w-6 h-6 text-[#d1fd98]" aria-hidden="true" />
            </a>
            <p>&copy; {{ date('Y') }} Weather Dashboard. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showMenu(menu, openIcon, closeIcon, button) {
            menu.classList.remove('hidden');
            setTimeout(() => menu.classList.remove('opacity-0', '-translate-y-4'), 10);
            
            openIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            button.setAttribute('aria-expanded', 'true');
        }

        function hideMenu(menu, openIcon, closeIcon, button) {
            menu.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => menu.classList.add('hidden'), 200);
            
            openIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
        }

        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-open');
            const closeIcon = document.getElementById('menu-close');
            const button = openIcon.parentElement;

            menu.classList.contains('hidden')
                ? showMenu(menu, openIcon, closeIcon, button)
                : hideMenu(menu, openIcon, closeIcon, button);
        }
    </script>
</body>
</html>
