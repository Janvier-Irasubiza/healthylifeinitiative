@section('title', 'My special orders')

<x-ht-clt-layout>
<div class="w-full px-4 py-4">
        <div class="d-flex justify-content-between">
            <h1 class="c-name py-2">My special orders</h1>
            <a href="{{ route('client.place_order') }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                <div>MAKE A SPECIAL ORDER</div>
            </a>
        </div>

        <div class="scrollable-section mb-2">
        <div class="flex-section gap-3">

        @foreach($orders as $order)


            @if(Session::has('deletion_success'))

            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="background-color: rgb(28, 236, 112); border: none">
            <div class="toast-header justify-content-between px-3 py-3" style="border: none">
                <div class="d-flex gap-3 align-items-center">
                <span><strong class="mr-auto">{{ Session::get('deletion_success') }}</strong></span>
                </div>
                    @if(Session::has('order_id'))
                    <a style="font-weight: bold" class="text-danger text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('undo-spcl', ['order_id' => Session::get('order_id')]) }}">
                        {{ __('Undo') }}
                    </a>
                    @endif
                    
                <button type="button" id="close" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            </div>

            @endif

            
            <div class="order-desc border border-transparent col-lg-4 p-2 mt-3">
                
                <div class="d-flex gap-3">

                    <div class="w-full">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <h1 class="c-head" >{{ $order -> product }}</h1>
                            <a href="{{ route('offload-spcl', ['order_id' => $order -> id]) }}" class="delete-btn" style="font-size: 13px">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>

                        <div class="py-2">
                            <small class="py-2">@php echo substr($order -> description, 0, 135); @endphp...</small>
                        </div>

                        <div class="w-full d-flex justify-content-between mt-2">
                        <div>
                            <div style="">
                                <p class="" style="font-weight: 500"> Status: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order -> status }}</small>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div style="">
                                <p class="" style="font-weight: 500"> Request time: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order -> request_date }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>

                </div>
                
            </div>

        @endforeach
        </div>
        </div>

        <div class="flex-section just-fy-content-between gap-3">

        
        <div class="w-full py-2 pb-3 mt-3 mb-3">
        <h1 class="c-name py-2 mb-2">Suggested products</h1>
        
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
</x-ht-clt-layout>