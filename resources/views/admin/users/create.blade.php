@extends('admin.admin')
@section('title','Créer un utilisateur')
@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-900 px-4 py-8">
    <div class="w-full max-w-lg bg-gray-800 rounded-lg shadow p-6">
        @if(session('success'))
            <div class="bg-green-800 text-green-100 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-2xl font-bold mb-6 text-gray-100">Créer un utilisateur</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-200">Nom</label>
                <input type="text" name="name" class="w-full border border-gray-600 rounded px-3 py-2 bg-gray-700 text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-200">Email</label>
                <input type="email" name="email" class="w-full border border-gray-600 rounded px-3 py-2 bg-gray-700 text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-200">Mot de passe</label>
                <input type="password" name="password" class="w-full border border-gray-600 rounded px-3 py-2 bg-gray-700 text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-200">Confirmer mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-600 rounded px-3 py-2 bg-gray-700 text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-200">Rôle</label>
                <select name="role" class="w-full border border-gray-600 rounded px-3 py-2 bg-gray-700 text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                    <option value="owner">Owner</option>
                    <option value="agent">Agent</option>
                </select>
            </div>
            <div class="relative text-white blur:text-black">

                <label class="block text-sm font-medium text-white mb-1" for="phone">
                    Téléphone
                </label>

                <i class="fas fa-phone-alt absolute left-3 top-2/3 transform -translate-y-1/2 text-gray-400"></i>

                <input
                    id="phone"
                    type="tel"
                    class="w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 "
                    placeholder="06 12 34 56 78"
                >

                <input type="hidden" name="phone" id="full_phone">

            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Créer</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const input  = document.querySelector("#phone");
    const form   = document.querySelector("form"); // plus fiable
    const hidden = document.querySelector("#full_phone");

    if (!input || !form || !hidden || !window.intlTelInput) return;

    const iti = window.intlTelInput(input, {
        initialCountry: "mg",
        separateDialCode: true,
        nationalMode: false,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js"
    });

    form.addEventListener("submit", function (e) {

        const fullNumber = iti.getNumber();

        if (!fullNumber || !iti.isValidNumber()) {

            e.preventDefault();

            Swal.fire({
                icon: "error",
                title: "Numéro invalide",
                text: "Veuillez entrer un numéro valide"
            });

            return;
        }

        hidden.value = fullNumber;

    });

});
</script>

@endsection