@extends('admin.admin')

@section('content')
<div class="max-w-6xl text-gray-400 mx-auto p-6 space-y-6">

    <div class="grid md:grid-cols-3 gap-6">

        <div class="md:col-span-2 bg-slate-900 p-5 rounded-xl">
            <h2 class="text-xl font-semibold mb-3">Bien concerné</h2>

            <p class="text-lg font-bold">{{ $notification->data['title'] }}</p>

            <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}"
               class="text-indigo-400 underline mt-2 inline-block">
                Voir le bien
            </a>
        </div>

        <div class="bg-slate-900 p-5 rounded-xl">
            <h2 class="text-xl font-semibold mb-3">Client</h2>

            <p><i class="fas fa-user mr-2"></i>{{ $notification->data['client'] }}</p>
            <p><i class="fas fa-envelope mr-2"></i>{{ $notification->data['email'] }}</p>
            <p><i class="fas fa-phone mr-2"></i>{{ $notification->data['phone'] }}</p>
        </div>

    </div>

    <div class="bg-slate-900 p-6 rounded-xl">
        <h2 class="text-xl font-semibold mb-4">Message</h2>

        <p class="text-slate-300">
            {{ $notification->data['message'] }}
        </p>
    </div>

    <div class="flex gap-4">

        <form method="POST"
              action="{{ route('admin.notifications.mail', $notification) }}">
            @csrf
            <button class="px-5 py-2 bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-paper-plane mr-2"></i>
                Répondre par mail
            </button>
        </form>

        <a href="tel:{{ $notification->data['phone'] }}"
           class="px-5 py-2 bg-green-600 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-phone mr-2"></i>
            Appeler le client
        </a>

    </div>

</div>
@endsection