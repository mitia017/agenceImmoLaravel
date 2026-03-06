@props([
    'label' => '',
    'name',
    'rows' => 4,
    'value' => ''
])

<div>
    <label for="{{ $name }}"
           class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => '
                w-full h-20 px-3 py-2 text-sm rounded-md
                border border-gray-300 dark:border-gray-700
                bg-white dark:bg-gray-900
                text-gray-900 dark:text-gray-100
                placeholder-gray-400 dark:placeholder-gray-500
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                transition resize-none
            '
        ]) }}
    >{{ old($name, $value ?? '') }}</textarea>
</div>
