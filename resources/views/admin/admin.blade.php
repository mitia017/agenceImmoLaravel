<!DOCTYPE html >
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('output.css') }}">
    @yield('tomselect')
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <script src="{{ asset('output.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.css">

    <title>@yield('title') | Administration</title>
</head>
<body>
    <div class="flex-2  bg-gray-100 dark:bg-gray-900 shadow-sm sm:rounded-lg overflow-auto">
        <div class="flex h-screen w-full ">
            <div class="flex h-screen fixed">
                <x-navigation></x-navigation>
            </div>
            <div class="w-full h-full ml-48">
            <x-flash></x-flash>
                @yield('content')
            </div>
        </div>
    </div>
    @yield('tomselector')
    <script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // empêche la soumission immédiate

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // soumission si confirmé
                }
            });
        });
    });
    </script>
  </body>  
</html>