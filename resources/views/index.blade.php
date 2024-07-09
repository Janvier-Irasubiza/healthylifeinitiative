@section('title', 'Home')

<x-ht-layout>
    <div class="body">

    <div id="demo" class="carousel slide mb-5" data-bs-ride="carousel">

        <div class="carousel-indicators d-none d-md-flex  justify-content-center">
            @foreach($posters as $key => $poster)
                <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $key }}" @if($key === 0) class="active" @endif></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($posters as $key => $poster)
          			<div class="carousel-item @if($key === 0) active @endif">
                      <img src="{{ asset('images/posters') }}/{{ $poster -> photo }}" alt="..." class="d-block" style="width:100%">
                      @if($poster->name == 'social')
                        <div class="mt-2 d-none d-md-block">
                          <div class="talk-to-us w-full text-center rounded "  style="border: none">
                            <div class="s-medias">
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
                      @endif
          			</div>
            @endforeach
        </div>

        <button class="carousel-control-prev d-none d-md-block" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next d-none d-md-block" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>



    <div class="ctgr-hold mt-3">
    <h1 class="c-name mb-3">Explore by categories</h1>
    <div class="by-category">
        <div class="card-container">
            @foreach($categories as $category)
            <a href="{{ route('products', ['category' => $category -> uuid]) }}" class="card-ctgr">
                <div class="card-img d-flex justify-content-center">
                    <img class="w-full" src="{{ asset('images/products/categories') }}/{{ $category->poster }}" alt="poster">
                </div>
                <div class="card-desc">
                    <h4 class="c-head">{{ $category -> category }}</h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>



        <div class="ctgr-hold mt-4 mb-3">
             <h1 class="c-name mb-3">Popular products</h1>
            <div class="products justify-content-start gap-3">
                @foreach($products as $product)
                <a href="{{ route('product', ['product' => $product->uuid]) }}" class="card item-card">
                    <div class="item-card-img d-flex justify-content-center">
                        <img class="w-full" src="{{ asset('images/products/' . $product->poster) }}" alt="poster">
                    </div>
                    <div class="item-card-desc gap-2">
                        <div><h4 class="c-head">{{ $product->name }}</h4></div>
                        <div class="d-flex gap-3">
                            @php
                                $likedProducts = DB::table('liked_products')->where('liked_session', session()->getId())->where('product', $product->id)->get();
                            @endphp
                            @if(!$likedProducts->isEmpty())
                            <span class="heart-icon" data-product-id="{{ $product->id }}"><i class="fa-regular fa-heart take-action" style="color: #f0ad4e"></i></span>
                            @else
                            <span class="heart-icon" data-product-id="{{ $product->id }}"><i class="fa-regular fa-heart take-action"></i></span>
                            @endif
                            <span class="cart-icon" data-product-id="{{ $product->id }}"><i class="fa-solid fa-cart-shopping take-action"></i></span>
                        </div>
                    </div>
                </a>
                @endforeach
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

    
    $(document).ready(function() {
    var container = $('.card-container');
    var cardWidth = $('.card-ctgr').outerWidth(true); // Include margin
    var scrollSpeed = 1; // Adjust scroll speed as needed
    var transitionInterval = 5000; // Interval for card transition in milliseconds

    function transitionCards() {
        // Clone the first card and append it to the container
        var firstCard = container.children().first().clone();
        container.append(firstCard);

        // Animate the container to move the first card out of view
        container.animate({marginLeft: -cardWidth}, 'slow', function() {
            // Remove the original first card from the container
            container.children().first().remove();
            // Reset container's margin-left to 0
            container.css('marginLeft', 0);
        });
    }

    // Set up timer to trigger card transition periodically
    setInterval(transitionCards, transitionInterval);
    });




</script>

</x-ht-layout>