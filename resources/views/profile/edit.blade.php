<x-app-layout>
    <link rel="stylesheet" href="{{ asset('output.css') }}">
    <script src="{{ asset('output.js') }}"></script>
    
    <div class="flex h-100">
        <div class="flex h-screen fixed">
            <x-navigation></x-navigation>
        </div>
        <div class="py-12 ml-48">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
