@section('title', $product -> name)

<x-ht-layout>
    <div class="body">
    
        <div class="path mt-1 mb-2">
            {{ $ctgr -> category }} / {{ $product -> name }}
        </div>

        <div class="product-info">
            <div class="img-cont">
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic1 }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic2 }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic3 }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic4 }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic5 }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $product -> pic5 }}" alt="">
                </div>
            </div>
            
            <div class="item-content w-full">
                <div class="item-cont w-full item-img-full">
                    <img id="fullImage" src="{{ asset('images/products') }}/{{ $product -> poster }}" alt="">
                </div>
                <div class="w-full desc">
                    <h2 class="item-name">
                        {{ $product -> name }}
                    </h2>

                    <p class="product-short-desc">
                        {{ $product -> description }}
                    </p>
				
                    <div class="prod-det mt-2 rounded">
                        <strong>More bout {{ $product -> name }}</strong>
                        <div class="d-flex align-items-between gap-2">
                            <div class="values rounded mt-2">
                                <span><i><strong>Added values</strong></i></span>
                                <ul class="mt-1">
                                  	@foreach($Values as $value)
                                    	<li><i class="fa-regular fa-circle-check"></i> {{ $value }}</li>
                                  	@endforeach
                                </ul>
                            </div>

                            <div class="values rounded mt-2">
                                <span><i><strong>Benefits to your life</strong></i></span>
                                <ul class="mt-1">
                                  	@foreach($Benefits as $benefit)
                                    	<li><i class="fa-regular fa-circle-check"></i> {{ $benefit }}</li>
                                  	@endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-5 align-items-center">
                    
                    @php
                    $promo= $product -> promo_price;
                    $price = $product -> price;
                    $save = ($price) - ($promo);
                    @endphp

                    <form action="{{ route('confirm-order') }}"> @csrf 

                    <input type="hidden" value="{{ $product -> uuid }}" name="p">
                    <div class="d-flex gap-5 mt-1 align-items-center">
                    <div>
                        <small class="fw-500">Quantity</small></br>
                        <select name="qty" id="qtySelector" class="select" style="">

                            @for ($qty = 1; $qty <= $product->quantity; $qty++)
                                <option id="qty" value="{{ $qty }}">{{ $qty }} {{ $product->quantity_unit }}</option>
                            @endfor

                        </select>
                        </div>

                    <div class="">
                        @if(!is_null($product -> promo_price))

                            <p class="price">
                                <span id="price" data-value="{{ $product -> promo_price }}"> {{ $product -> promo_price }} </span> RWF
                            </p>

                            <input type="hidden" data-cont="{{ $product -> promo_price }}" id="priceInpt" name="price_inpt" value="{{ $product -> promo_price }}">

                            <p class="m-0 off-price"><span> {{ $product -> price }} </span> &nbsp; Save &nbsp; {{ $save }} RWF </p>
                            @else
                            <p class="price">
                                <span id="price" data-value="{{ $product -> price }}"> {{ number_format($product -> price) }} </span> RWF
                            </p>

                            <input type="hidden" data-cont="{{ $product -> price }}" id="priceInpt" name="price_inpt" value="{{ $product -> price }}">

                            <p class="m-0 off-price"><small> {{ $product -> motive }} </small></p>

                        @endif
                    </div>

                    </div>

                    <div class="d-flex action-btns gap-3 mt-4">
                        <button type="submit" class="p-btns fw-500">buy now</button>
                        <a href="{{ route('add-to-cart', ['product' => $product -> id]) }}" type="submit" class="s-btns fw-500">add to cart</a>
                    </div>

                    </form>

                    </div>

                </div>
            </div>
            </div>

        <div class="ctgr-hold mt-5 mb-3">
             <h1 class="c-name mb-3">Related products</h1>
            <div class="products gap-3">
            @foreach($related as $rel)
            <a href="{{ route('product', ['product' => $rel->uuid]) }}" class="card item-card">
                    <div class="item-card-img d-flex justify-content-center">
                        <img src="{{ asset('images/products/' . $rel->poster) }}" alt="poster">
                    </div>
                    <div class="item-card-desc gap-2">
                        <div><h4 class="c-head">{{ $rel->name }}</h4></div>
                        <div class="d-flex gap-3">
                            @php
                                $likedProducts = DB::table('liked_products')->where('liked_session', session()->getId())->where('product', $rel->id)->get();
                            @endphp
                            @if(!$likedProducts->isEmpty())
                            <span class="heart-icon" data-product-id="{{ $rel->id }}"><i class="fa-regular fa-heart take-action" style="color: #f0ad4e"></i></span>
                            @else
                            <span class="heart-icon" data-product-id="{{ $rel->id }}"><i class="fa-regular fa-heart take-action"></i></span>
                            @endif
                            <span class="cart-icon" data-product-id="{{ $rel->id }}"><i class="fa-solid fa-cart-shopping take-action"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
        </div>

        <script>
            const selectEl = document.querySelector('#qtySelector');
            const qtyOption = document.querySelectorAll('#qty');
            const price = document.querySelector('#price');
            const priceInpt = document.querySelector('#priceInpt');

            selectEl.addEventListener('change', (e) => {
                qtyOption.forEach((item) => {
                    let amount = e.target.value * price.dataset.value;
                    price.textContent = (amount).toLocaleString(undefined);
                    priceInpt.value = amount;
                });
            });

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
        

        document.addEventListener("DOMContentLoaded", function () {
        const smallImages = document.querySelectorAll('.item-img img');
        const fullImageContainer = document.querySelector('.item-cont');
        const fullImage = document.getElementById('fullImage');

        smallImages.forEach(function (img) {
            img.addEventListener('mouseenter', function () {
            fullImage.src = img.src;
            fullImageContainer.style.display = 'block'; 
        });

        img.addEventListener('mouseleave', function () {
            fullImage.src = '{{ asset('images/products') }}/{{ $product->poster }}';
        });

            img.addEventListener('click', function (event) {
                fullImage.src = img.src;
                event.stopPropagation(); 
            });
        });

        fullImageContainer.addEventListener('mouseleave', function () {
            fullImageContainer.style.display = 'block';
        });

        fullImageContainer.addEventListener('click', function () {
            fullImageContainer.style.display = 'block';
        });
    });
        </script>
</x-ht-layout>