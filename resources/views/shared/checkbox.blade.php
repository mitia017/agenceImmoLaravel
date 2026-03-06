@php
    $class ??=null;
@endphp

<div @class(["form-chek form-switch", $class])>
    <input type="hidden" value="0" name="{{ $name }}">
    <input @checked(old($name, $value ?? false)) value="1" type="checkbox" name="{{ $name }}" class="form-check-input @error($name) is-invalid @enderror" role="switch" id="{{ $name }}">
    <label for="{{ $name }}">{{ $label }}</label>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>