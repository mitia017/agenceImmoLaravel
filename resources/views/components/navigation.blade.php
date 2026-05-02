@php
    $route = request()->route()->getName();
@endphp
<div class="w-48 h-full flex flex-col">
    <div class="p-6 flex items-center gap-2">
        <span class="text-[#2a2438] font-bold text-sm">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </span>
        <span class="text-white font-semibold text-lg">{{ Auth::user()->name }}</span>
    </div>
    <nav class="flex-1 px-3">
        <a href="{{ route('dashboard') }}" @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'dashboard'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'dashboard')])>
            <i class="fas fa-tachometer-alt"></i>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="{{ route('profile.edit') }}" @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'profile'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'profile')])>
            <i class="fas fa-user"></i>
            <span class="text-sm">{{ __('Profile') }}</span>
        </a>
        <a href="{{ route('admin.property.index') }}" @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'property.'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'property.')])>
            <i class="fas fa-layer-group"></i>
            <span class="text-sm">Gérer les biens</span>
        </a>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.option.index') }}" @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'option'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'option.')])>
            <i class="fas fa-cogs"></i>
            <span class="text-sm">Gérer les options</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'users'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'users.')])>
            <i class="fas fa-users"></i>
            <span class="text-sm">Gérer les utilisateurs</span>
        </a>
        @endif
        <a href="{{ route('admin.notifications.index') }}"
        @class(['w-full flex items-center gap-3 px-4 py-3 rounded-lg mb-1', 'bg-[#3d3451] text-white' => str_contains($route, 'notifications.'), 'text-gray-400 hover:text-white hover:bg-[#3d3451]' => !str_contains($route, 'notifications.')])>
            <i class="fas fa-bell w-5"></i>
            <span>Notifications</span>

            @if(auth()->user()->unreadNotifications()->count())
                <span class="ml-auto bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ auth()->user()->unreadNotifications()->count() }}
                </span>
            @endif
        </a>
        
    </nav>
    <a href="#" class="flex items-center gap-3 px-7 py-4 text-gray-400 hover:text-white">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center gap-3 px-7 py-4 text-gray-400 hover:text-white">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span class="text-sm">Logout</span>
            </button>
        </form>
    </a>
</div>