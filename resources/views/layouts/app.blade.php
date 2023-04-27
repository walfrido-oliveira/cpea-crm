<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('layouts.favicon')

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col justify-between">

            <div class="flex md:flex-row flex-col w-full">
                @include('top-menu')
            </div>

            <div class="flex md:flex-row flex-col flex-grow">
                @include('sidebar')

                <!-- Page Content -->
                <main class="w-full">
                    {{ $slot }}
                </main>
            </div>

            <footer>
                <p class="text-center">{{ __("© Copyright - CPEA 2021") }}</p>
            </footer>

        </div>

        @stack('modals')

        @livewireScripts

        <script>
            @if(Session::has('message'))
              window.addEventListener("load", function() {
                toastr.options.closeButton = true;
                var type = "{!! Session::get('alert-type', 'info') !!}";
                switch(type){
                    case 'info':
                        toastr.info("{!! Session::get('message') !!}");
                        break;

                    case 'warning':
                        toastr.warning("{!! Session::get('message') !!}");
                        break;

                    case 'success':
                        toastr.success("{!! Session::get('message') !!}");
                        break;

                    case 'error':
                        toastr.error("{!! Session::get('message') !!}");
                        break;
                }
              });
            @endif
        </script>
    </body>
</html>
