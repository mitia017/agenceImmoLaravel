@extends('admin.admin')
@section('title','Gestion des utilisateurs')
@section('content')

<div class="min-h-screen bg-gray-900 text-gray-100 px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Utilisateurs</h1>
            @can('create', App\Models\User::class)
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Créer un utilisateur
            </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="bg-green-800 text-green-100 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="text-left px-6 py-3">Nom</th>
                        <th class="text-left px-6 py-3">Email</th>
                        <th class="text-left px-6 py-3">Rôle</th>
                        <th class="text-left px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 divide-y divide-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-3">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-3 flex space-x-2">
                            @can('updateRole', $user)
                            <form action="{{ route('admin.users.updateRole',$user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="role" class="border-gray-600 rounded px-2 py-1 bg-gray-800 text-gray-100">
                                    <option value="owner" @selected($user->role=='owner')>Owner</option>
                                    <option value="agent" @selected($user->role=='agent')>Agent</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 text-white px-2 py-1 rounded hover:bg-indigo-700 transition">Modifier</button>
                            </form>
                            <form action="{{ route('user.destroy', $user) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Supprimer</button>
                            </form>
                                
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection