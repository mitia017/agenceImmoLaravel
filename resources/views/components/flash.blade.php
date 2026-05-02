@if (session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif
@if($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'error',
                title: "{{ $error }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endforeach
@endif