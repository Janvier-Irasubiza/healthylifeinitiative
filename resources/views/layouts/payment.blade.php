<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Health Target - @yield('title') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('styles.css')) }}">

        <!-- Scripts -->
        <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/jquery-1.7.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body> 

        <main class="d-flex justify-content-center py-5">

            <div class="border rounded pyt-lyt">
                
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('index') }}">
                    <div class="logo" style="">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    </div>
                </a>
              
              @if(Auth::user())
              	<a href="{{ route('client.dashboard') }}" class="home-btn border rounded"> Go to Home </a>
              @else
              	<a href="{{ route('index') }}" class="home-btn border rounded"> Go to Home </a>
              @endif
              
            </div>

                {{ $slot }}
                
<footer class="w-full mt-5 pyt-footer" style="background: ghostwhite; border-top: 1px solid #e6e6e6; ">

<div class="rsp-f-footer">
        <div>
            &copy; Health Target Ltd. All rights reserved
        </div>
        <div class="dev">
           <i class="fa-solid fa-code"></i><strong> RB-A</strong>
        </div>
    </div>

    <div class="f-footer">
        <div class="">
            <p class="f-15 m-0">&copy; Health Target Ltd. All rights reserved </p>
        </div>
        <div>
            <p class="f-15 m-0">Developed by <strong>RB-A</strong></p>
        </div>
    </div>
</footer>

            </div>

        </main>

        <script>
            $('.drower').on('click', function () {
                $('.rsp-nav').toggleClass('show');
            });
        </script>

    </body>
</html>