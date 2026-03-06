@extends('admin.admin')
@section('title', $property->exists ? 'Editer un bien' : 'Créer un bien')
@section('tomselect')
    <link rel="stylesheet" href="{{ asset('tomSelect/select.css') }}">
    <script src="{{ asset('tomSelect/select.js') }}"></script>
@endsection
@section('content')
<div class="flex h-full w-full justify-center  bg-gray-100 dark:bg-gray-800">
    <form action="{{ route($property->exists ? 'admin.property.update' : 'admin.property.store', $property) }}" method="POST" enctype="multipart/form-data">
        <h1 class="text-white text-3xl">@yield('title')</h1>
        @csrf
        @method($property->exists ? 'PUT' : 'POST')
        <div class="grid grid-cols-1 gap-x-6 gap-y-3 text-white mb-3">
            <!-- Titre -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-form.input label="Titre" name="title" required :value="old('title', $property->title ?? '')"/>
                <x-form.input label="Surface (m²)" name="surface" type="number" :value="old('surface', $property->surface ?? '')"/>
                <x-form.input label="Prix ($)" name="price" type="number" :value="old('price', $property->price ?? '')"/>
            </div>
            <x-form.textarea label="Description" name="description" rows="5" :value="old('description', $property->description ?? '')"/>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-form.input label="Nombre de pièces" name="rooms" type="number" :value="old('rooms', $property->rooms ?? '')"/>
                <x-form.input label="Nombre de chambres" name="bedrooms" type="number" :value="old('bedrooms', $property->bedrooms ?? '')"/>
                <x-form.input label="Nombre d'étages" name="floor" type="number" :value="old('floor', $property->floor ?? '')"/>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-form.input label="Ville" name="city" :value="old('city', $property->city ?? '')"/>
                <x-form.input label="Adresse" name="address" :value="old('address', $property->address ?? '')"/>
                <x-form.input label="Code postal" name="postal_code" :value="old('postal_code', $property->postal_code ?? '')"/>
            </div>
            
            <x-form.select
                label="Options"
                name="options"
                :options="$options"
            />
            <!-- Vendu -->
            <x-form.switch label="Vendu" name="sold" value="{{ $property->sold }}" />
            <div>
                <label class="block font-semibold">Photos du bien</label>
                <input type="file" name="images[]" multiple
                    class="mt-2 block w-full border rounded p-2">
            </div>
            <!-- Actions -->
           <button type="submit"
                class="h-10 px-6 flex items-center justify-center rounded-md
                    bg-blue-700 hover:bg-blue-400 text-white font-medium transition mb-6">
                @if ($property->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
            <x-flash></x-flash>
        </div>
    </form>
</div>
@section('tomselector')
    <script>
       const select = document.querySelector('select[multiple]');
         new TomSelect(select, {plugins: {remove_button: {title: 'Supprimer'}}})
    </script>
@endsection
@endsection