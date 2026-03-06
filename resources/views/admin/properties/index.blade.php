@extends('admin.admin')

@section('title', 'Tous les biens')

@section('content')
<div class="w-9/12 mx-auto px-4 py-6  bg-gray-100 dark:bg-gray-900">
    @if(session('success'))
        <div class="bg-green-800 text-green-100 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <!-- Titre + Bouton Ajouter -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">@yield('title')</h1>

        <a href="{{ route('admin.property.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Ajouter un nouveau bien
        </a>
    </div>

    <div class="overflow-x-auto bg-gray-800 shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Titre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Surface</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Prix</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Ville</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-white">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($properties as $property)
                    <tr class="hover:bg-gray-500 transition">
                        <td class="px-6 py- text-white">{{ $property->title }}</td>
                        <td class="px-6 py-4 text-white">{{ $property->surface }} m²</td>
                        <td class="px-6 py-4 text-white">{{ number_format($property->price, 0, ',', ' ') }} $</td>
                        <td class="px-6 py-4 text-white">{{ $property->city }}</td>

                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.property.edit', $property) }}"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                Éditer
                            </a>

                            <form action="{{ route('admin.property.destroy', $property) }}"
                                method="POST"
                                class="inline-block delete-form"
                                id="{{$property->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    {{ $properties->links() }}
@endsection