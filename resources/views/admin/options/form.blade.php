@extends('admin.admin')

@section('title', $option->exists ? 'Editer une option' : 'Créer une option')

@section('content')
    @php
        $store = 'admin.option.store';
        $update = 'admin.option.update';
    @endphp
    <div class="flex h-full w-screen justify-center  bg-gray-100 dark:bg-gray-800">
    <form action="{{ route($option->exists ? $update : $store , $option) }}"
    method="POST"
    class="gap-x-6 gap-y-3 text-white flex flex-col w-1/2"
    >
        <h1 class="text-white text-md md:text-xl lg:text-3xl">@yield('title')</h1>
        @csrf
        @method($option->exists ? 'PUT' : 'POST')
        <div class="w-3/4">
            <x-form.input label="Nom" name="name" required :value="old('nom', $option->name ?? '')"/>
        </div>
        <div>
            <button type="submit"
                class="h-10 px-6 flex items-center justify-center rounded-md
                    bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                @if ($option->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>
@endsection