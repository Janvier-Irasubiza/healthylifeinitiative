@section('title', 'Market place')

<x-ht-clt-layout>
    <div class="body">

        <div class="slider">    
            <img src="{{ asset('images/products/market.png') }}" alt="">
        </div>

        <div class="ctgr-hold mt-4 mb-5">

        <div class="d-flex justify-content-between gap-3">
             <h1 class="c-name mb-3">Products</h1>
             <div class="mt-2 mb-4 mrkt-ctgr">
                <small><strong>Sort by Categories: </strong></small>
                @foreach($categories as $ctgr)
                <a href="{{ route('client.sort-market', ['ctgr' => $ctgr -> id]) }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150 mb-1" style="color: black; font-size: 13px">
                    <div>{{ $ctgr -> category }}</div>
                </a>
                @endforeach
             </div>
        </div>
            <div class="products justify-content-start gap-3">
            
                @foreach($products as $product)

                <a href="{{ route('client.product', ['product' => $product -> uuid]) }}" class="card item-card">
                    <div class="item-card-img d-flex justify-content-center">
                        <img class="w-full" src="{{ asset('images/products') }}/{{ $product -> poster }}" alt="poster">
                    </div>
                    <div class="item-card-desc gap-2">
                        <div><h4 class="c-head">{{ $product -> name }}</h4></div>
                        <div class="d-flex gap-3">
                            @php
                                $likedProducts = DB::table('liked_products')->where('liked_by', Auth::user() -> id)->where('product', $product->id)->get();
                                $cartProducts = DB::table('cart')->where('client', Auth::user() -> id)->where('product', $product->id)->get();
                            @endphp
                            @if(!$likedProducts->isEmpty())
                            <span class="heart-icon" data-product-id="{{ $product->id }}"><i class="fa-regular fa-heart take-action" style="color: #f0ad4e"></i></span>
                            @else
                            <span class="heart-icon" data-product-id="{{ $product->id }}"><i class="fa-regular fa-heart take-action"></i></span>
                            @endif
                            @if(!$cartProducts->isEmpty())
                            <span class="cart-icon" data-product-id="{{ $product->id }}"><i class="fa-solid fa-cart-shopping take-action" style="color: #f0ad4e"></i></span>
                            @else
                            <span class="cart-icon" data-product-id="{{ $product->id }}"><i class="fa-solid fa-cart-shopping take-action"></i></span>
                            @endif
                        </div>
                    </div>
                </a>

                @endforeach

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const heartIcons = document.querySelectorAll('.heart-icon');
            heartIcons.forEach(icon => {
                icon.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Handle heart icon click event here
                    // You can use AJAX to send data to the server or perform any other action
                });
            });

            const cartIcons = document.querySelectorAll('.cart-icon');
            cartIcons.forEach(icon => {
                icon.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = icon.getAttribute('data-product-id');
                    const addToCartUrl = `/add-to-cart/${productId}`;
                    window.location.href = addToCartUrl; 
                });
            });

            const heartIcon = document.querySelectorAll('.heart-icon');
            heartIcon.forEach(icon => {
                icon.addEventListener('click', function(event) {
                    event.preventDefault();
                    const idProduct = icon.getAttribute('data-product-id');
                    const likeUrl = `/like/${idProduct}`;
                    window.location.href = likeUrl;
                });
            });
        });
    </script>
</x-ht-layout>