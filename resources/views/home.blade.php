@extends('base')
@section('title', 'Agence')
@section('content')

<!-- HERO SECTION -->
<div class="bg-blue-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Agence Immobilier</h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis veniam, vero voluptates labore tempora autem atque inventore iste itaque minus dolor ea est soluta ducimus voluptatem doloremque, ipsum dolorem quam!
        </p>
    </div>
</div>

<!-- PROPERTIES GRID -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Nos derniers biens</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($properties as $property)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-8 hover:scale-110 hover:shadow-xl">
                @if($property->images->first())
                    <img src="{{ asset('storage/' . $property->images->first()->path) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('images/thumbnail-default.png') }}" 
                        alt="Pas d'image pour ce bien" 
                        class="w-full h-48 object-cover">
                @endif

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($property->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-blue-600">{{ number_format($property->price, 0, ',', ' ') }} €</span>
                        <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}"
                           class="text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Voir
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection