@extends('admin.admin')

@section('content')

<div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between">
        <h1 class="text-2xl text-gray-300 font-bold mb-6">Notifications</h1>
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="border border-gray-400 focus:outline-none text-gray-500 text-sm font-semibold px-4 hover:bg-gray-800 hover:text-white rounded-2xl py-2">
                <i class="fas fa-check"></i> Marquer comme lu
            </button>
        </form>
    </div>

    <div class="bg-slate-900 rounded-xl divide-y divide-slate-800">

        @forelse($notifications as $notif)
            <a href="{{ route('admin.notifications.show', $notif) }}"
               class="flex justify-between p-4 hover:bg-slate-800 transition">

                <div>
                    <p class="font-semibold {{ is_null($notif->read_at) ? 'text-indigo-400' : 'text-gray-400' }}">
                        {{ $notif->data['client'] }}
                    </p>
                    <p class="text-sm text-slate-400">
                        {{ $notif->data['title'] }}
                    </p>
                </div>

                <span class="text-xs text-slate-500 flex gap-4" >
                    {{ $notif->created_at->diffForHumans() }}
                    <div>
                        <form action="{{ route('admin.notifications.destroy', ['notification' => $notif]) }}"
                              method="POST"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class=" hover:bg-gray-700 text-red500 px-4 py-2 rounded">
                                    <i class="fa fa-trash text-red-500"></i>
                            </button>
                        </form>
                        
                    </div>
                </span>
                
            </a>
        @empty
            <p class="p-6 text-center text-slate-400">Aucune notification</p>
        @endforelse

    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>

</div>
@endsection