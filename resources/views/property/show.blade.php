@extends('base')

@section('title', $property->title)

@section('content')
    <div class="space-y-6">
        <a href="/biens" class="inline-flex items-center text-gray-600 hover:text-blue-500 smooth-transition">
            <i class="fas fa-angles-left mr-2"></i>
            Retour aux propriétés
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image Carousel -->

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                    <di class="relative h-80 bg-gray-200 overflow-hidden">
                        
                        @if($property->images->count())
                            <img 
                                id="carousel-image"
                                src="{{ asset('storage/'.$property->images[0]->path) }}"
                                class="w-full h-full object-cover"
                                alt="Image du bien"
                            >
                        @else
                            <img 
                                src="{{ asset('images/thumbnail.png') }}"
                                class="w-full h-full object-cover"
                                alt="Image du bien"
                            >
                        @endif

                        <button 
                            id="prevBtn"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-gray-100 opacity-50 hover:opacity-100 transition-opacity duration-300 rounded-full p-2 shadow"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <button 
                            id="nextBtn"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-gray-100 opacity-50 hover:opacity-100 transition-opacity duration-300 rounded-full p-2 shadow"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <div class="absolute top-4 right-4">
                            @if (!$property->sold)
                                <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-200 text-green-800">
                                    Disponible <i class="fa-solid fa-check text-green-800"></i>
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-full text-sm font-bold bg-red-400 text-red-900">
                                    Vendu <i class="fa-solid fa-x text-red-800"></i>
                                </span>
                            @endif
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {

                                const images = @json(
                                    $property->images->pluck('path')
                                        ->map(fn($p) => asset('storage/'.$p))
                                        ->values()
                                );

                                let index = 0;

                                const img = document.getElementById('carousel-image');
                                const next = document.getElementById('nextBtn');
                                const prev = document.getElementById('prevBtn');

                                if (!img || !next || !prev || images.length <= 1) return;

                                next.addEventListener('click', function () {
                                    index = (index + 1) % images.length;
                                    img.src = images[index];
                                });

                                prev.addEventListener('click', function () {
                                    index = (index - 1 + images.length) % images.length;
                                    img.src = images[index];
                                });

                            });
                        </script>
                    </div>

                </div>

                <!-- Property Info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>

                    <div class="flex items-center text-gray-600 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $property->address }}, {{ $property->postal_code }} {{ $property->city }}</span>
                    </div>

                    <p class="text-4xl font-bold text-blue-600 mb-6">€{{ $property->price }}</p>

                    <!-- Features Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-home text-blue-600 text-2xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->rooms }}</p>
                            <p class="text-sm text-gray-600">Pièces</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-bed text-blue-600 text-2xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</p>
                            <p class="text-sm text-gray-600">Chambres</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-expand text-blue-600 text-2xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->surface }}</p>
                            <p class="text-sm text-gray-600">m²</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-layer-group text-blue-600 text-2xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->floor }}</p>
                            <p class="text-sm text-gray-600">Étage</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">Description</h2>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $property->description }}
                        </p>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Équipements</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($options as $option)
                                <div class="flex items-center space-x-2 text-green-600">
                                    <i class="fas fa-check"></i>
                                    <span class="text-sm">{{ $option }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        Demander une visite
                    </h2>

                    <form method="POST" id="message" action="{{ route('property.contact', $property) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- COLONNE GAUCHE -->
                        <div class="space-y-6">
                            <!-- Nom -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <i class="fas fa-user absolute left-3 top-2/3 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="lastname" placeholder="John"
                                    class="w-full pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Prénom -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                <i class="fas fa-user-friends absolute left-3 top-2/3 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="firstname" placeholder="Doe"
                                    class="w-full pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Email -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <i class="fas fa-envelope absolute left-3 top-2/3 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="email" placeholder="john@example.com"
                                    class="w-full pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Téléphone -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="phone" >Téléphone</label>
                                <i class="fas fa-phone-alt absolute left-3 top-2/3 transform -translate-y-1/2 text-gray-400"></i>
                                <input id="phone" type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="06 12 34 56 78" />
                                <input type="tel" name="phone" id="full_phone" class="hidden"/>
                                <script>
                                document.addEventListener('DOMContentLoaded', function () {

                                    const input  = document.querySelector("#phone");
                                    const form   = document.getElementById("message");
                                    const hidden = document.getElementById("full_phone");

                                    if (!input || !form || !hidden) return;

                                    const iti = window.intlTelInput(input, {
                                        initialCountry: "auto",
                                        separateDialCode: true,
                                        nationalMode: false,
                                        geoIpLookup: function (callback) {
                                            try {
                                                const lang = navigator.language || navigator.userLanguage;
                                                const country = lang.split('-')[1];
                                                callback(country ? country.toLowerCase() : 'mg');
                                            } catch {
                                                callback('mg');
                                            }
                                        },
                                        utilsScript:
                                            "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js"
                                    });

                                    form.addEventListener('submit', function (e) {

                                        const fullNumber = iti.getNumber();

                                        console.log("NUMERO:", fullNumber);
                                        console.log("VALID:", iti.isValidNumber());

                                        if (!fullNumber || !iti.isValidNumber()) {
                                            e.preventDefault();
                                            Swal.fire({
                                                toast: true,
                                                position: 'bottom-end',
                                                icon: 'error',
                                                title: "Numéro Invalide",
                                                showConfirmButton: false,
                                                timer: 3000
                                            });
                                            return;
                                        }

                                        hidden.value = fullNumber;
                                    });

                                });
                                </script>
                            </div>
                        </div>
                        <!-- COLONNE DROITE -->
                        <div class="flex flex-col justify-between space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea name="message" rows="6"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Je suis intéressé par ce bien..."></textarea>
                            </div>

                            <button type="submit" 
                                class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Envoyer la demande
                            </button>
                            <x-flash></x-flash>
                            <p class="text-xs text-gray-500 text-center">
                                Réponse sous 24h ouvrées
                            </p>

                            <!-- AGENT INFO -->
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                        MC
                                    </div>
                                    <div>
                                        @php
                                            $user = $property->getUser();
                                            $name = $user->name;
                                            $role = $user->role;
                                        @endphp
                                        <p class="font-medium text-gray-900">{{ $name }}</p>
                                        <p class="text-xs text-gray-600">{{ $role }}</p>
                                    </div>
                                </div>

                                <a href="tel:{{ $user->phone }}"
                                    class="flex items-center justify-center gap-2 w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <i class="fas fa-phone"></i>
                                    Appeler l'agent
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection