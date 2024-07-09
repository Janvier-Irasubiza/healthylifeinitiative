<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Healthy Life Initiative - @yield('title') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('styles.css')) }}">

        <!-- Scripts -->
        <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body>

        <header>
             <div class="py-1 px-2 s-media">
               
                <div class="media-box w-full text-center rounded">
                    <div class="">
                        <ul class="d-flex justify-content-between gap-2">
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Join Our Whatsapp Community" target="blanc" href="https://wa.me/+250728228826"><span class="fa-brands fa-whatsapp" style="color: ghostwhite"></span></a> </li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Telegram" target="blanc" href="#"><span class="fa-brands fa-telegram" style="color: ghostwhite"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Twitter" target="blanc" href="https://twitter.com/Healthylif2024"><span class="fa-brands fa-twitter" style="color: ghostwhite"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Instagram" target="blanc" href="https://www.instagram.com/hinitiative/"><span class="fa-brands fa-instagram" style="color: ghostwhite"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On LinkedIn" target="blanc" href="https://www.linkedin.com/in/healthylife-initiative-12b989305/"><span class="fa-brands fa-linkedin" style="color: ghostwhite"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us Via Google Mail" target="blanc" href="mailto:healthylifeinitiative2024@gmail.com" style="color: ghostwhite"><span class="fa-brands fa-google"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Visit Our Youtube Channel" target="blanc" href="#" style="color: ghostwhite"><span class="fa-brands fa-youtube"></span></a></li></div>
                            <div><li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Facebook" target="blanc" href="#"><span class="fa-brands fa-facebook" style="color: ghostwhite"></span></a></li> </div>
                        </ul> 
                    </div>
                </div>
               </div>

            <nav>
                <div class="d-flex align-items-center">
                    <button class="drower">
                        <span class="fa-solid fa-bars"></span>
                    </button>

                    <a href="{{ route('index') }}" class="logo">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 70px">
                    </a>

                     <div class="nav-links">
                        <ul>
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('place_order') }}">Special order</a></li>
                            <li><a href="{{ route('market') }}">Market</a></li>
                            <li><a href="{{ route('about') }}">About us</a></li>
                        </ul>
                    </div>
                </div>

                <form action="{{ route('search') }}" method="get">
                @csrf
                    <div class="search">
                        <div>
                            <input name="searchQuery" type="search" placeholder="Search for a product" required>
                        </div>
                    </div>
                </form>

                <!-- Container to display search results -->
                <div id="searchResults"></div>

                    <div class="nav-icons">
                        <ul>
                            <li>
                                <div style="position: relative">
                                    <a href="{{ route('cart') }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        @if(!empty($cart) && count($cart) > 9)
                                        <span style="position: absolute; top: -6px; left: 10px; font-size: 10px; padding: 4px" class="badge badge-light bg-danger" >{{ count($cart) }}+</span>
                                        @elseif(!empty($cart) && count($cart) > 0)
                                        <span style="position: absolute; top: -6px; left: 10px; font-size: 10px; padding: 3px 4px" class="badge badge-light bg-danger" >{{ count($cart) }}</span>
                                        @endif
                                    </a>
                                </div>
                            </li>
                            <li>
                                @if(Auth::user())

                                    <a href="{{ route('client.dashboard') }}">
                                        <div class="user">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    </a>

                                @else 

                                    <a href="{{ route('client-login') }}">
                                        <div class="user">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    </a>

                                @endif
                            </li>
                        </ul>
                    </div>
            </nav>

            <div class="rsp-nav">
                <ul class="rsp-nav-links">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('place_order') }}">Special order</a></li>
                    <li><a href="{{ route('market') }}">Market</a></li>
                    <li><a href="{{ route('about') }}">About us</a></li>
                </ul>
            </div>

            <form action="{{ route('search') }}" method="get" class="search-form">
            @csrf
            <div class="rsp-search d-flex">
                        <input name="searchQuery" type="search" placeholder="Search a product" required>
                        <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
            </form>
                    
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


        <main class="body">
            {{ $slot }}
          
          	<div class="reach-to-us">
                <a href="https://wa.me/+250728228826" target="_blank" class="d-flex justify-content-between gap-2">
                    <i class="fa-brands fa-whatsapp" style="font-size: 30px"></i>
                    <span>Talk to Us</span>
                </a>
            </div>
        </main>

        <footer>
            <div class="f-head flex-section gap-4">
                <div class="company">
                    <h2 class="c-name">Welcome to Healthy Life Initiative</h2>
                    <p class="mt-3 c-text">
						This platform  aims at improving  people's healthy lifestyle  by mitigating  non communicable  diseases and risk factors through nutritional guidance ,availing and selling  food supplements, and assistive  products tailored to one's  needs.                  
                  	</p>
                </div>
                <div class="dm">
                </div>
                <div class="contacts">
                    <h3 class="c-name">Reach out to us</h3>
                    <div class="d-block mt-3">
                        <li class="c-text"><i class="fa-solid fa-phone"></i> &nbsp; +250 793 083 966</li>
                        <li class="mt-1 c-text"><i class="fa-solid fa-envelope"></i> &nbsp; healthylifeinitiative2024@gmail.com</li>
                        <li class="mt-1 c-text"><i class="fa-solid fa-location-dot"></i> &nbsp; Kigali, Rebero</li>
                    </div>
                </div>
            </div>

            <div class="f-links mt-5">
                <ul>
                    
                </ul>
            </div>

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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        $('.drower').on('click', function () {
            $('.rsp-nav').toggleClass('show');
        });
       
        $('.carousel').carousel({
            interval: 2000
        });

        const selectEl = document.querySelectorAll('.select');
                const price = document.querySelectorAll('#price');
                const totalPriceElement = document.getElementById('totalPrice');

                selectEl.forEach((select, index) => {
                    select.addEventListener('change', (e) => {
                        const quantity = parseInt(e.target.value);
                        const unitPrice = parseFloat(price[index].getAttribute('data-value'));
                        const amount = quantity * unitPrice;
                        price[index].textContent = amount.toLocaleString(undefined);

                        let totalSum = 0;
                        price.forEach(priceElement => {
                            totalSum += parseFloat(priceElement.getAttribute('data-value')) * parseInt(priceElement.parentNode.previousElementSibling.querySelector('.select').value);
                        });
                        totalPriceElement.textContent = totalSum.toLocaleString(undefined);
                    });
                });

                document.getElementById('close').addEventListener('click', function () {
                    document.getElementById('toast').style.display = 'none';
                });
    </script>

    </body>

</html>