@section('title', 'Dashboard')

<x-ht-clt-layout>

@php
    $likedProducts = DB::table('liked_products')->where('liked_by', Auth::user() -> id)-> get();
@endphp

<div class="w-full px-4 py-4">
        <div class="d-flex justify-content-between">
            <h1 class="c-name py-2">My orders</h1>
            <a href="{{ route('client.spclorders') }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                <div>SPECIAL ORDERS</div>
            </a>
        </div>

        <div class="scrollable-section mb-2">
        <div class="flex-section gap-3">

        @if(!$my_order->isEmpty())
        @foreach($my_order as $order)

        @if(Session::has('deletion_sucess'))

        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="background-color: rgb(28, 236, 112); border: none">
        <div class="toast-header justify-content-between px-3 py-3" style="border: none">
            <div class="d-flex gap-3 align-items-center">
            <span><strong class="mr-auto">{{ Session::get('deletion_sucess') }}</strong></span>
            </div>
            @if(Session::has('order_id'))
            <a style="font-weight: bold" class="text-danger text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('undo-delete', ['order_id' => Session::get('order_id')]) }}">
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
                
                    <div class="item-img" style="border: none   ">
                        <img src="{{ asset('images/products') }}/{{ $order -> product_poster }}" alt="">
                    </div>

                    <div class="w-full">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <h1 class="c-head" >{{ $order -> product_name }}</h1>
                            <a href="{{ route('offload-order', ['order_id' => $order -> order_id]) }}" class="delete-btn" style="font-size: 13px">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>

                        <div class="w-full d-flex justify-content-between mt-2">
                        <div>
                            <div>
                                <p class="" style="font-weight: 500"> Delivery: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order -> delivery_mode }}</small>
                                        @if(!($order -> delivery_mode == 'Pick Up'))
                                        <a class="underline text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('update-delivery', ['order_id' => $order -> order_id]) }}">
                                            {{ __('Change') }}
                                        </a>
                                        @else
                                        <a class="underline text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('address', ['order_id' => $order -> order_id]) }}">
                                            {{ __('Change') }}
                                        </a>
                                        @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div>
                                <p class="" style="font-weight: 500"> Status: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order -> progress }}</small>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div>
                                <p class="" style="font-weight: 500"> Payment: </p>
                                @if($order -> payment_status == "Pending")
                                <div class="buttons px-0 py-1 bg-danger" style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative"><strong>PAY</strong></small>
                                </div>
                                @elseif($order -> payment_status == "Processing")
                                <div class="buttons px-0 py-1 bg-warning" style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative"><strong>PROCESS</strong></small>
                                </div>
                                @elseif($order -> payment_status == "Paid")
                                <div class="buttons px-0 py-1" style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative"><strong>PAID</strong></small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    </div>

                </div>
                
            </div>

        @endforeach
        @else
            <div class="text-center  px-5 py-3 w-full">
                
                <div>
                    <p> You haven't placed any order yet! </p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('client.market-place') }}" class="buttons-cstm fw-500">START SHOPPING</a>
                </div>

            </div>
        @endif

        </div>
        </div>

        <div class="flex-section just-fy-content-between gap-3">
            <div class="px-3 py-2 pb-3 item-sect-div border border-transparent mt-3">

            <form action="{{ route('client.checkout') }}" method="post"> @csrf

                <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                    
                <div>
                    <h1 class="c-name py-2">My shopping cart</h1>
                </div>

                    <div class="d-flex justify-content-between align-items-center gap-3">
                    
                    @if(!$cart->isEmpty())

                    <div>
                        <h2 class="form-title-sub" style="font-size: 15px" id="totalPrice">Sub total: &nbsp; {{ number_format($cart->sum('price')) }} RWF</h2>
                        <input type="hidden" name="totalPrice" id="totalPriceInpt" value="{{ $cart->sum('price') }}">
                    </div>

                    <div class="">
                        <button type="submit" class="buttons" style="font-weight: 500; font-size: 10px; padding: 4px 8px"> CHECKOUT </button>
                    </div>

                    @endif

                    </div>
                </div>
                @if(!$cart->isEmpty())
            <table class="w-full">
                <tr>
                    <th colspan="2">Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th class="text-center">Offload</th>
                </tr>

                @foreach($cart as $productId => $product)

                <tr style="border-bottom: 1px solid #ddd">
                    <td>
                        <input type="hidden" name="product[]" value="{{ $product->product }}">
                        <div class="item-img" style="border: none   ">
                            <img src="{{ asset('images/products') }}/{{ $product->image }}" alt="">
                        </div>
                    </td>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        <select name="qty" id="qtySelector" class="select">
                            @for ($qty = 1; $qty <= $product->max_quantity; $qty++)
                                @if($product->quantity == $qty)
                                    <option id="qty" value="{{ $qty }}" data-product-id="{{ $product->id }}" selected>{{ $qty }} {{ $product->quantity_unit }}@if($qty > 1 && $product->quantity_unit != 'kg')s @endif</option>
                                @else
                                    <option id="qty" value="{{ $qty }}" data-product-id="{{ $product->id }}">{{ $qty }} {{ $product->quantity_unit }}@if($qty > 1 && $product->quantity_unit != 'kg')s @endif</option>
                                @endif
                            @endfor
                        </select>
                        <input type="hidden" id="quantity" name="quantity[]" value="{{ $product->quantity }}">
                    </td>
                    <td>
                        <p class="m-0"><span id="price" data-value="{{ $product->unit_price }}"> {{ number_format($product->price) }} </span> RWF</p>
                        <small style="color: #8c8c8c"> @if($product->promo_price != null) {{ number_format($product->promo_price) }}  @else {{ number_format($product->unit_price) }} @endif RWF Unit price</small>
                        <input type="hidden" id="price_inpt" name="price_inpt" value="{{ $product->price }}">
                    </td>
                    <td class="text-center">
                        <a href="{{ route('remove-item', ['product_id' => $product->id]) }}" class="delete-btn">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>

                @endforeach

            </table>

            @else 
                
            <div class="text-center  px-5">
                
                <div>
                    <p> You don't have any items in your cart. </p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('client.market-place') }}" class="buttons-cstm fw-500">START SHOPPING</a>
                </div>

            </div>
            
            @endif

            </form>
        </div>

        <div class="px-3 py-2 pb-3 item-sect border border-transparent mt-3">
        <h1 class="c-name py-2 mb-2">My Wishlist</h1>
        <table class="w-full">
                <tr>
                    <th colspan="2">Product</th>
                    <th>Price</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Ofload</th>
                </tr>
                
                @foreach($likedProducts as $like)

                @php
                    $likedProduct = DB::table('products') -> where('id', $like -> product) -> first();
                @endphp
                <tr style="border-bottom: 1px solid #ddd">
                    <td>
                        <div class="item-img" style="border: none   ">
                            <img src="{{ asset('images/products') }}/{{ $likedProduct -> poster }}" alt="">
                        </div>
                    </td>
                    <td>
                        {{ $likedProduct -> name }}
                    </td>
                    <td>
                        {{ $likedProduct -> price }} RWF <br>
                        <small style="font-weight: 500">( 1 <i> {{ $likedProduct -> quantity_unit }}</i> )</small>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('client.product', ['product' => $likedProduct -> uuid]) }}" class="buttons rounded" style="padding: 2px 20px 3px 20px; border-radius: 4px; color: white">
                            <strong>BUY</strong>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('wishlist-remove', ['idProduct' => $likedProduct->id]) }}" class="delete-btn">
                            <i class="fa-solid fa-thumbs-down"></i>
                        </a>
                    </td>
                </tr>
                </a>
                @endforeach
            </table>
        </div>
        </div>

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
    <script>
$(document).ready(function() {
    $('select#qtySelector').on('change', function() {
        var qty = $(this).val();
        var productId = $(this).find('option:selected').data('product-id');
        var pricePerUnit = $(this).closest('tr').find('span#price').data('value');
        
        $(this).closest('tr').find('input#quantity').val(qty);

        var totalPrice = qty * pricePerUnit;
        $(this).closest('tr').find('span#price').text(totalPrice.toLocaleString(undefined));
        $(this).closest('tr').find('input#price_inpt').val(totalPrice);

        updateTotalPrice();
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/add-to-cart/' + productId,
            type: 'GET',
            data: { qty: qty },
            success: function(response) {
                // Handle success if needed
            },
            error: function(xhr, status, error) {
                // Handle error if needed
            }
        });
    });

    function updateTotalPrice() {
        var totalPrice = 0;
        $('input#price_inpt').each(function() {
            totalPrice += parseFloat($(this).val());
        });
        $('h2#totalPrice').html('Sub total: &nbsp; ' + totalPrice.toLocaleString(undefined) + ' RWF');
        $('input#totalPriceInpt').val(totalPrice);
    }
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
      
      document.getElementById('close').addEventListener('click', function () {
        document.getElementById('toast').style.display = 'none';
      });
   
</script>


</x-ht-clt-layout>