@extends('base')
@section('title', 'Tous nos biens')
@section('content')

<!-- SEARCH FORM -->
<div class="bg-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @include('shared.flash')

        <form action="" method="get" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <input type="number" name="price" placeholder="Budget max" 
                   value="{{ $input['price'] ?? '' }}"
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <input type="number" name="surface" placeholder="Surface minimale" 
                   value="{{ $input['surface'] ?? '' }}"
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <input type="number" name="rooms" placeholder="Nombre de pièce" 
                   value="{{ $input['rooms'] ?? '' }}"
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <input name="title" placeholder="Mot clef" 
                   value="{{ $input['title'] ?? '' }}"
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Rechercher
            </button>
        </form>
    </div>
</div>

<!-- PROPERTIES GRID -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if($properties->count() > 0)
    <h1 class="text-3xl font-bold text-gray-900 text-center mb-8">@yield('title')</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($properties as $property)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-4 hover:scale-105 hover:shadow-2xl">
                    @if($property->images->first())
                        <img src="{{ asset('storage/' . $property->images->first()->path) }}" 
                             alt="{{ $property->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('images/thumbnail-default.png') }}" 
                             alt="Thumbnail" 
                             class="w-full h-48 object-cover">
                    @endif

                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($property->description, 100) }}</p>

                        <div class="flex justify-between items-center mb-4">
                            <div class="flex space-x-4 text-gray-500 text-sm">
                                <span><i class="fas fa-bed mr-1"></i> {{ $property->bedrooms ?? 0 }} Chambres</span>
                                <span><i class="fas fa-house mr-1"></i> {{ $property->rooms ?? 0 }} Pièces</span>
                                <span><i class="fas fa-ruler-combined mr-1"></i> {{ $property->surface ?? 0 }} m²</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="font-bold text-blue-600">{{ number_format($property->price, 0, ',', ' ') }} €</span>
                            <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}"
                               class="text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Voir
                            </a>
                        </div>
                    </div>

                    @if($property->status == 'Vendu')
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                            Vendu
                        </div>
                    @elseif($property->status == 'Disponible')
                        <div class="absolute top-4 left-4 bg-green-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                            Disponible
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $properties->links() }}
        </div>
    @else
        <div class="text-center text-gray-500 text-xl mt-12">
            Aucun bien disponible !!!
        </div>
    @endif
</div>

@endsection