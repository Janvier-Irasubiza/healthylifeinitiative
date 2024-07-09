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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

    <header>
            <nav  class="">
                <div class="d-flex align-items-center">
                    <button class="drower">
                        <span class="fa-solid fa-bars"></span>
                    </button>

                    <div class="sm-logo" >
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 70px">
                    </div>

                     <div class="nav-links">
                        <ul>
                            <li><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('client.place_order') }}">Make a pecial order</a></li>
                            <li><a href="{{ route('client.market-place') }}">Marketplace</a></li>
                        </ul>
                    </div>
                </div>
                    <div class="d-flex nav-icons align-items-center gap-2">

                    <a href="{{ route('client.messages') }}" style="font-size: 17px"><i class="fa-solid fa-comment-dots"></i></a>

                        <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150">
                            <div>
                              
                              @php
                                $names = explode(' ', Auth::user() -> name);
                                $firstName = $names[0];
                                $lastName = $names[count($names) - 1];
                                $initial = substr($lastName, 0, 1);
                                @endphp
                                      
                              {{ $initial . '. ' . $firstName }}
                              
                              </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('client.profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
                    </div>
            </nav>

            <div class="ad-rsp-nav">
                        <ul class="rsp-nav-links">
                            <li><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('client.place_order') }}">Special order</a></li>
                            <li><a href="{{ route('client.market-place') }}">Marketplace</a></li>
                        </ul>
                    </div>
                    
        </header> 
        
        @if(Session::has('success'))

        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="background-color: rgb(28, 236, 112); border: none">
        <div class="toast-header justify-content-between px-3 py-3" style="border: none">
            <div class="d-flex gap-3 align-items-center">
            <span><strong class="mr-auto">{{ Session::get('success') }}</strong></span>
            </div>
            <button type="button" id="close" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>

        @endif

        @if(Session::has('failed'))

        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="background-color: rgb(236, 28, 28); border: none">
        <div class="toast-header justify-content-between px-3 py-3" style="border: none">
            <div class="d-flex gap-3 align-items-center">
            <span><strong class="mr-auto">{{ Session::get('failed') }}</strong></span>
            </div>
            <button type="button" id="close" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>

        @endif

        @if(Session::has('change_success'))

        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="background-color: rgb(28, 236, 112); border: none">
        <div class="toast-header justify-content-between px-3 py-3" style="border: none">
            <div class="d-flex gap-3 align-items-center">
            <span><strong class="mr-auto">{{ Session::get('change_success') }}</strong></span>
            </div>
            <button type="button" id="close" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>

        @endif

        <main>
            {{ $slot }}
        </main>

        <footer class="w-full" style="background: ghostwhite; border-top: 1px solid #d9d9d9; position: fixed; bottom: 0px; padding-top: 0px; z-index: 10">

        <div class="rsp-f-footer">
                <div>
                    <small>&copy; <strong>More Steps Ahead LTD.</strong> All rights reserved</small> 
                </div>
                <div class="dev">
                    <button id="smContactButton" class="shake"> <i class="fa-solid fa-code"></i> &nbsp; <strong>RB-A</strong></button>
                </div>
            </div>

            <div class="f-footer">
                <div>
                    <small>Powered by <strong>More Steps Ahead LTD.</strong> All rights reserved</small> 
                </div>
                <div>
                    <small>Developed by <button id="contactButton" class="shake"><strong>RB-A</strong></button></small>
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
                $('.ad-rsp-nav').toggleClass('show');
            });

            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                }
            };
          
          document.getElementById('close').addEventListener('click', function () {
                document.getElementById('toast').style.display = 'none';
            });

    //         const selectEl = document.querySelectorAll('.select');
    //     const price = document.querySelectorAll('#price');
    //     const totalPriceElement = document.getElementById('totalPrice');

    //     selectEl.forEach((select) => {
    //     select.addEventListener('change', (e) => {
    //         const productId = e.target.getAttribute('data-product-id');
    //         const quantity = parseInt(e.target.value);

    //         fetch(`/change-cart-item/${productId}?quantity=${quantity}`, {
    //             method: 'POST', 
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}' 
    //             },
    //         })
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error('Network response was not ok');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('There was a problem with the fetch operation:', error);
    //         });
    //     });
    // });

           
        </script>

    </body>
</html>