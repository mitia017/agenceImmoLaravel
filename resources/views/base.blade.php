<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="{{ asset('output.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('tel.css') }}">
    <script src="{{ asset('tel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>@yield('title')</title>
</head>
<nav class="bg-gray-800 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- LEFT: Logo + Biens -->
            <div class="flex items-center space-x-6">
                <a href="/" class="text-2xl font-bold
                    translate-y-[-2px] hover:translate-y-[-4px]
                    transition-transform after:content-['']
                    hover:after:absolute hover:after:-bottom-1
                    hover:after:left-0 hover:after:w-full hover:after:h-0.5
                    hover:after:bg-white hover:after:rounded-md"
                >
                   <i class="fa fa-house"></i> Agence
                </a>

                @php
                    $route = request()->route()->getName();
                @endphp

                <a href="{{ route('property.index') }}"
                   class="font-medium transition-transform hover:-translate-y-1 relative
                   @if(str_contains($route, 'property.')) after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-white after:rounded-md @endif
                   after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-white hover:after:rounded-md">
                    Biens
                </a>
            </div>

            <!-- RIGHT: Login -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('login') }}"
                   class="font-medium transition-transform hover:-translate-y-1 relative
                   @if(str_contains($route, 'login')) after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-white after:rounded-md @endif
                   after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-white hover:after:rounded-md">
                    Log in
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="focus:outline-none text-white text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
        <a href="{{ route('property.index') }}"
           class="block py-2 font-medium relative
           @if(str_contains($route, 'property.')) after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-white after:rounded-md @endif
           after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-white hover:after:rounded-md">
            Biens
        </a>
        <a href="{{ route('login') }}"
           class="block py-2 font-medium relative
           @if(str_contains($route, 'login')) after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-white after:rounded-md @endif
           after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-white hover:after:rounded-md">
            Log in
        </a>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>


<body>
  @yield('content')
</body>
</html>