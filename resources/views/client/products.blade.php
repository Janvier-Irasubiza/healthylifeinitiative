@section('title', $category -> category . ' products')

<x-ht-clt-layout>
    <div class="body">

        @php
            $ctgrs = DB::table('categories') -> where('id', '!=', $category -> id) -> get();
        @endphp

        <div class="slider">    
            <img src="{{ asset('images/products/categories') }}/{{ $category -> banner }}" alt="">
        </div>

        @if(!$products->isEmpty())
        <div class="ctgr-hold mt-4 mb-3">
             <h1 class="c-name mb-3">Products</h1>
            <div class="products justify-content-start gap-3">
            
                @foreach($products as $product)

                <a href="{{ route('client.product', ['slag' => $product -> slag]) }}" class="card item-card">
                    <div class="item-card-img d-flex justify-content-center">
                        <img src="{{ asset('images/products/' . $product->poster) }}" alt="poster">
                    </div>
                    <div class="item-card-desc gap-2">
                        <div><h4 class="c-head">{{ $product->name }}</h4></div>
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
        @else
        <div class="ctgr-hold mt-4 mb-3 text-center py-5">
            <h1 class="c-name mb-3">Seems like there's nothing in {{ $category -> category }} for now!</h1>

            <div class="mt-4 px-2">
                <a href="{{ route('client.dashboard') }}" class="buttons-cstm fw-500">GO HOME</a>
            </div>

            @foreach($ctgrs as $ctgr)
            <div class="mt-4 px-2">
                <a href="{{ route('client.products', ['category' => $ctgr -> slag]) }}" class="buttons-cstm fw-500">GO TO {{ $ctgr -> category }}</a>
            </div>
            @endforeach
        </div>
        @endif

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

</x-ht-clt-layout>