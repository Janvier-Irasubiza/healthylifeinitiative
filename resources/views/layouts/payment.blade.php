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
                        <button id="smContactButton" class="shake"> <i class="fa-solid fa-code"></i> &nbsp; <strong>RB-A</strong></button>
                    </div>
                </div>

                <div class="f-footer">
                    <div class="">
                        <p class="f-15 m-0">&copy; Health Target Ltd. All rights reserved </p>
                    </div>
                    <div>
                        <p class="f-15 m-0">Developed by <button id="contactButton" class="shake"><strong>RB-A</strong></button></p>
                    </div>
                </div>
            </footer>

            <div id="popup" class="popup p-4 border col-md-6 bg-gray-200">
                <div class="flex justify-between">
                    <h1 class="text-gray-600 form-title">RhythmBox Associations</h1>
                    <button id="closePopup">Close</button>
                </div>
                <div class="mt-4 flex-section gap-3">
                   <div class="col-md-4 border-r mb-4">
                   <h2 class="text-gray-600 text-center form-title-sub">Contact</h2>
                    <div class="mt-6">

                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">+250 781 336 634</p>
                    </div>
                    <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">+250 780 478 405</p>
                    </div>

                    <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-envelope f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">arhythmbox@gmail.com</p>
                    </div>

                   </div>
                   <div class="w-full">
                   <h2 class="text-gray-600 form-title-sub">Send us a message</h2>
                    <form action="{{ route('send.email') }}" method="POST" class="mt-3" id="contactForm"> @csrf
                        <div>
                        <label for="name" class="label" >Names</label>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="How can we address you?" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-3">
                            <label for="email" class="label" >Email</label>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- phone number -->
                        <div class="mt-3">
                        <label for="message" class="label" >Request</label>
                        <textarea id="request" class="block mt-1 w-full border-gray rounded" name="request" required placeholder="Type your request here...">{{ old('requests') }}</textarea>
                            <x-input-error :messages="$errors->get('request')" class="mt-2" />
                        </div>

                        <div id="messageDiv" class="mt-3"></div>

                        <div class="mt-6 flex items-center justify-between">

                            <x-primary-button class="p-btn">
                                {{ __('Send message') }}
                            </x-primary-button>
                        </div>
                    </form>
                   </div>
                </div>
            </div>

            </div>

        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

            $(document).ready(function() {
                function toggleShakeAnimation(enableShake) {
                    if (enableShake) {
                        $('#contactButton').addClass('shaking');
                        $('#smContactButton').addClass('shaking');
                    } else {
                        $('#contactButton').removeClass('shaking');
                        $('#smContactButton').addClass('shaking');
                    }
                }

                $('#contactButton').click(function() {
                    $('#popup').slideDown();
                    toggleShakeAnimation(false);
                });

                $('#smContactButton').click(function() {
                    $('#popup').slideDown();
                    toggleShakeAnimation(false);
                });

                $('#closePopup').click(function() {
                    $('#popup').slideUp();
                    toggleShakeAnimation(true);
                });

                toggleShakeAnimation(true);

                $('#contactForm').submit(function(e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        var $submitButton = $(this).find('button[type="submit"]');
                        var originalButtonText = $submitButton.html();
                        $submitButton.prop('disabled', true).html('Sending...');

                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                $('#messageDiv').html('<p class="text-green-600">Message sent successfully. We will reach out to you shortly.</p>');
                                $('#contactForm').trigger('reset');
                            },
                            error: function(xhr, status, error) {
                                $('#messageDiv').html('<p class="text-red-600">Failed to send message. Please try again later.</p>');
                            },
                            complete: function() {
                            $submitButton.prop('disabled', false).html(originalButtonText);
                        }
                        });
                    });
            });

            $('.drower').on('click', function () {
                $('.rsp-nav').toggleClass('show');
            });
        </script>

    </body>
</html>