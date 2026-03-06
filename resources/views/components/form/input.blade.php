@props([
    'label' => '',
    'name',
    'type' => 'text',
    'value' => '',
    'required' => false
])

<div>
    <label for="{{ $name }}"
           class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-3">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => '
                w-full h-10 px-3 py-2 text-sm rounded-md
                border border-gray-300 dark:border-gray-700
                bg-white dark:bg-gray-900
                text-gray-900 dark:text-gray-100
                placeholder-gray-400 dark:placeholder-gray-500
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                transition
            '
        ]) }}
    >
</div>
