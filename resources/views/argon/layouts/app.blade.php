<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Argon Dashboard') }}</title>
    {{-- <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script> --}}

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link
        href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.1" rel="stylesheet">
    @stack('css')
</head>

<body class="{{ $class ?? '' }}">
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif



    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$errors->first()}}'
            })
        </script>
    @endif
   
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @include('argon.layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
    @include('argon.layouts.navbars.navbar')
    @yield('content')
    </div>

    @guest()
        @include('argon.layouts.footers.guest')
    @endguest

    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')

    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

    <script>


        function deleteBtn(deleteRouteUrl) {
            Swal.fire({
                title: 'Do you want to Delete?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                // denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: deleteRouteUrl,
                        type: 'DELETE',
                        success: function(result) {
                            if (result.status) {
                                Swal.fire('Deleted!', '', 'success').then((ttt) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Something went wrong!', '', 'info')
                            }
                        }
                    });

                } else if (result.isDenied) {
                    // Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }


        // Swal.fire({
        //     title: 'Error!',
        //     text: 'Do you want to continue',
        //     icon: 'error',
        //     confirmButtonText: 'Cool'
        // })
    </script>



    <style>
        input[type="file" i] {
            appearance: none;
            background-color: unset;
            cursor: default;
            align-items: unset;
            color: unset;
            text-overflow: unset;
            white-space: unset;
            text-align: unset !important;
            padding: unset;
            border: unset;
            overflow: hidden !important;
        }

        .fileinput div {
            padding-top: 10px
        }
    </style>
    </body>

</html>
