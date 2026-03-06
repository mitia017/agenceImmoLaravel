@extends('admin.admin')

@section('title', 'Tous les options')

@section('content')
<div class="w-9/12 mx-auto px-4 py-6  bg-gray-100 dark:bg-gray-800">

    <!-- Titre + Bouton Ajouter -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">@yield('title')</h1>

        <a href="{{ route('admin.option.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Ajouter une option
        </a>
    </div>>   
   <div class="overflow-x-auto bg-gray-800 shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xl font-semibold text-white">Nom</th>
                  <th class="px-6 py-3 text-right text-xl font-semibold text-white">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($options as $option)
                <tr class="hover:bg-gray-500 transition">
                    <td class="px-6 py- text-white">{{ $option->name }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.option.edit', $option) }}"
                           class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Éditer
                        </a>

                        <form action="{{ route('admin.option.destroy', $option) }}"
                              method="POST"
                              class="inline-block delete-form">
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
        <div class="text-center mt-10">
            <x-flash></x-flash>
        </div>
    </div>

</div>
    {{ $options->links() }}
@endsection