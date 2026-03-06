@php
    $class ??= null;
@endphp

<div @class(["flex items-center space-x-3", $class])>
    <!-- Label -->
    <label for="{{ $name }}" class="text-white select-none">
        {{ $label }}
    </label>

    <!-- Switch -->
    <div class="relative inline-block w-12 h-7">
        <input type="hidden" name="{{ $name }}" value="0">
        <input 
            type="checkbox" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="1"
            @checked(old($name, $value ?? false))
            class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer"
        >
        <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-full transition-colors duration-300
                    peer-checked:bg-blue-600"></div>
        <div class="absolute left-0 top-0.5 w-6 h-6 bg-white rounded-full shadow transform transition-transform duration-300
                    peer-checked:translate-x-5"></div>
    </div>

    <!-- Error -->
    @error($name)
        <div class="text-red-500 text-sm">
            {{ $message }}
        </div>
    @enderror
</div>
