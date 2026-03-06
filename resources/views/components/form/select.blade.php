@props([
    'label' => '',
    'name',
    'options' => [],
    'selected' => null,
    'multiple' => false
])

<div>
    <label for="{{ $name }}"
           class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
    </label>

    <select
        name="{{ $name }}[]}}"
        id="{{ $name }}"
        multiple
        {{ $attributes->merge([
            'class' => 'w-full '
        ]) }}
    >
        
        @foreach ($options as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
        @endforeach
    </select>
</div>
