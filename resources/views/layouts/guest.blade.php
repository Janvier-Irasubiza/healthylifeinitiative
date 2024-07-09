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
        <link rel="stylesheet" href="{{ asset('styles.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/jquery-1.7.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body> 

        <main class="d-flex justify-content-center py-5">

            <div class="auth-div">
                
            <div class="d-flex justify-content-center">
                <a href="{{ route('index') }}">
                    <div class="logo d-flex justify-content-center">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 70px">
                    </div>
                </a>
            </div>

                {{ $slot }}
            </div>

        </main>

        <footer class="w-full" style="background: ghostwhite; border-top: 1px solid #ccc; position: fixed; bottom: 0px; padding-top: 0px; z-index: 10">

        <div class="rsp-f-footer">
                <div>
                    <small>&copy; <strong>More Steps Ahead LTD.</strong> All rights reserved</small> 
                </div>
                <div class="dev">
                   <i class="fa-solid fa-code"></i> <strong>RB-A</strong>
                </div>
            </div>

            <div class="f-footer">
                <div>
                    <small>Powered by <strong>More Steps Ahead LTD.</strong> All rights reserved</small> 
                </div>
                <div>
                    <small>Developed by <strong>RB-A</strong></small>
                </div>
            </div>
        </footer>

        <script>
            $('.drower').on('click', function () {
                $('.rsp-nav').toggleClass('show');
            });
        </script>

    </body>
</html>