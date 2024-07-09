@section('title', 'Shopping Cart')

<x-ht-layout>
    <div class="body">

        <div class="p-3 form-title">
            Shopping cart
        </div>

        @if(Auth::user())
        <form action="{{  route('client.checkout') }}" method="post"> @csrf

        
        <div class="product-info p-3 mb-5">
        @if(!$cart->isEmpty())
            <div class="col-lg-8">
                @else
                <div class="w-full">
                @endif

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

            </table>

            @else 
                
            <div class="text-center p-5">
                
                <div>
                    <p> You don't have any items in your cart. </p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('market') }}" class="buttons-cstm fw-500">START SHOPPING</a>
                </div>

            </div>
            

            @endif
            
            </div>
            
            @if(!$cart->isEmpty())
            <div class="col-lg-4">
            <div class="item-cont-cst d-flex justify-content-center align-items-center py-3 px-3">
                <div class="w-full">
                    <div class="path mt-1 mb-2">
                        Cart items: {{ count($cart) }} Items
                    </div>
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <h2 class="form-title-sub">Sub total</h2>
                            </div>

                            <div>
                                <h2 class="form-title" style="font-size: 18px" id="totalPrice">{{ number_format($subtotal) }} RWF</h2>
                                <input type="hidden" name="totalPrice" id="totalPriceInpt" value="{{ $subtotal }}">
                                </h2>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <button type="submit" type="submit" class="buttons w-full" style="font-weight: 500;"> GO TO CHECKOUT </button>
                        </div>

                        </div>
            </div>

                </div>

                @endif

            </div>
            </div>

            </form>

            @else 
            
            <form action="{{  route('checkout') }}" method="post"> @csrf

            
        <div class="product-info p-3 mb-5">
        @if(!$cart)
            <div class="w-full">

            @else 
            <div class="col-lg-8">
            @endif

            @if($cart)
             
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
                            <input type="hidden" name="product[]" value="{{ $product['id'] }}">
                            <div class="item-img" style="border: none   ">
                                <img src="{{ asset('images/products') }}/{{ $product['image'] }}" alt="">
                            </div>
                        </td>
                        <td>
                            {{ $product['name'] }}
                        </td>
                        <td>
                            <select name="qty" id="qtySelector" class="select">
                                @for ($qty = 1; $qty <= $product['max_quantity']; $qty++)
                                    @if($product['quantity'] == $qty)
                                        <option id="qty" value="{{ $qty }}" data-product-id="{{ $product['id'] }}" selected>{{ $qty }} {{ $product['quantity_unit'] }}@if($qty > 1 && $product['quantity_unit'] != 'kg')s @endif</option>
                                    @else
                                        <option id="qty" value="{{ $qty }}" data-product-id="{{ $product['id'] }}">{{ $qty }} {{ $product['quantity_unit'] }}@if($qty > 1 && $product['quantity_unit'] != 'kg')s @endif</option>
                                    @endif
                                @endfor
                            </select>
                            <input type="hidden" id="quantity" name="quantity[]" value="{{ $product['quantity'] }}">
                        </td>
                        <td>
                            <p class="m-0"><span id="price" data-value="{{ $product['unit_price'] }}"> {{ number_format($product['price']) }} </span> RWF</p>
                            <small style="color: #8c8c8c"> @if($product['promo_price'] != null) {{ number_format($product['promo_price']) }}  @else {{ number_format($product['unit_price']) }} @endif RWF Unit price</small>
                            <input type="hidden" id="price_inpt" name="price_inpt" value="{{ $product['price'] }}">
                        </td>
                        <td class="text-center">
                            <a href="{{ route('remove-item', ['product_id' => $product['id']]) }}" class="delete-btn">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach

            </table>

            </table>

            @else 
                
            <div class="text-center p-5">
                
                <div>
                    <p> You don't have any items in your cart. </p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('market') }}" class="buttons-cstm fw-500">START SHOPPING</a>
                </div>
                <div class="mt-3">
                    <small> 
                        Or <a href="{{ route('client-login') }}" class="fw-500" style="text-decoration: underline">Sign In</a>
                    </small>
                </div>

            </div>
            

            @endif
            
            </div>
            
            @if($cart)
            <div class="col-lg-4">
            <div class="item-cont-cst d-flex justify-content-center align-items-center py-3 px-3">
                <div class="w-full">
                    <div class="path mt-1 mb-2">
                        Cart items: {{ count($cart) }} Items
                    </div>
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <h2 class="form-title-sub">Sub total</h2>
                            </div>

                            <div>
                                <h2 class="form-title" style="font-size: 18px" id="totalPrice">{{ number_format($subtotal) }} RWF</h2>
                                <input type="hidden" name="totalPrice" id="totalPriceInpt" value="{{ $subtotal }}">
                                </h2>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <button type="submit" type="submit" class="buttons w-full" style="font-weight: 500;"> GO TO CHECKOUT </button>
                        </div>

                        </div>
            </div>

                </div>

                @endif
            </div>
            </div>

            </form>

            @endif


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
        $('h2#totalPrice').html(totalPrice.toLocaleString(undefined) + ' RWF');
        $('input#totalPriceInpt').val(totalPrice);
    }
});

            </script>

</x-ht-layout>