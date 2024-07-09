@section('title', 'Home')

<x-ht-clt-layout>
    <div class="body d-flex justify-content-center">

        <div class="col-lg-6 p-2 mb-5">

        <div class="path mt-1 mb-2">
            Dashboard / Harvard Nutrition / Checkout
        </div>

            <!-- <sub total> -->
            <div class="p-3 mt-3 mb-4" style="border: 1px solid #ddd; border-radius: 5px">
                <div class="d-flex justify-content-between gap-3">
                    <div class="path mt-1 mb-2">
                        Cart items: {{ number_format(count($cart)) }} Items
                    </div>

                    <div class="path mt-1 mb-2">
                        <button data-bs-toggle="modal" data-bs-target="#cartItems" class="border border-transparent px-2" style="border-radius: 4px">Preview</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between gap-3">
                <div>
                    <h2 class="form-title">Sub total</h2>
                </div>

                <div>
                    <h2 class="form-title-sub">
                        {{ number_format($validData['totalPrice']) }} RWF
                    </h2>
                </div>
                </div>
            </div>
            <!-- </sub total> -->

                <!-- <modal> -->
                <div class="modal fade" id="cartItems" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title form-title-sub" id="exampleModalLabel">My shopping cart</h5>
                        <button data-bs-dismiss="modal" class="border border-transparent px-2 bg-danger" style="border-radius: 4px; font-size: 15px; color: ghostwhite">Close</button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    </div>
                </div>
                </div>
                <!-- </modal> -->

            <div class="w-full">
                <div class="w-full">
                    <form action="{{ route('client.complete-order') }}" method="post">
                        <h2 class="form-title-sub">Confirm your order</h2>

                        @foreach($data_order as $order)

                        <input type="hidden" class="w-full" name="prod[]" value="{{$order['product']}}">
                        @endforeach

                        <div class="mt-4">
                        <label for="">Delivery mode</label>
                        <div class="flex-section gap-3">
                            <div id="doorStep" class="w-full d-flex align-items-center gap-3 dvr rounded">
                                <input type="radio" id="dStep" value="Door step" name="delivery" checked>
                                <label for="">Door step</label>
                            </div>

                            <div id="pickUp" class="w-full d-flex align-items-center gap-3 dvr rounded">
                                <input type="radio" id="pick" name="delivery" value="Pick up">
                                <label for="" class="w-full">Pick up</label>
                            </div>
                        </div>

                        <div class="mt-3" id="delivery_address">
                            <label for="" class="w-full" style="color: #ffaa00">By home delivery, be aware of some extra charges.</label>
                            <label for="" class="w-full mt-2">Home address</label>
                            <div class="d-flex gap-2">
                                <input class="w-full" type="text" name="city" placeholder="City/District">
                                <input class="w-full" type="text" name="sector" placeholder="Sector">
                                <input class="w-full" type="text" name="cell" placeholder="Cell">
                                <input class="w-full" type="text" name="village" placeholder="Village">
                            </div>

                            <textarea name="address_details" id="" rows="1" class="w-full rounded mt-2" placeholder="Describe your neighbourhood"></textarea>
                        </div>

                        <x-input-error :messages="$errors->get('delivery')" class="mt-2" />
                        </div>

                        <div class="mt-4">
            <div style="border-bottom: 1px solid #f2f2f24b">
            <label for="" class="w-full">Payment mode</label>
        	<small class="mb-0" style="color: #595959">Select your prefered payment method</small>
          <div class="flex-section gap-4">
          	<div class="w-full mb-3">
              <small class="mb-0" style="">Mobile money</small>
            	<button type="button" id="momobtn" class="col-lg-8 w-full p-1 paybtn" style="">
                  <div class="d-flex align-items-center gap-3 px-3">
                    <div class="col-lg-1"><input id="momochk" type="radio" name="payment_method" value="momo"></div> 
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img style="max-height: 100%" src="{{ asset('images/payments/momo1-logo.png') }}" alt=""></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 33px;"><img style="max-height: 100%" src="{{ asset('images/payments/airtel-logo-bg.png') }}" alt=""></div>
                  </div>
              	</button>
            </div>
          	<div class="w-full mb-3">
              <small class="mb-0">Credit card</small>
            	<button type="button" id="visabtn" class="col-lg-8 w-full p-1 paybtn">
                  <div class="d-flex align-items-center gap-2 px-3">
                    <div class="col-lg-1"><input id="visachk" type="radio" name="payment_method" value="cc"></div> 
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img style="max-height: 100%" src="{{ asset('images/payments/visa-logo.png') }}" alt=""></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img style="max-height: 100%" src="{{ asset('images/payments/Mastercard-logo.png') }}" alt=""></div>
                  </div>
              	</button>
            </div>
      
          </div>
          </div>
          </div>

          <div class="">
          
        <div class="phone-form">
        @csrf
                
          <div class="mt-3">
          <label for="" class="w-full">Phone number</label>
        <small class="mb-0" style="color: #595959">Provide phone number you intend to use for this payment</small>
            <input id="momochk" type="radio" name="payment_method" value="momo" checked hidden>
        <input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Phone number" autocomplete="phone" />
            <x-input-error :messages="session('phone')" class="mt-2 text-left" />
        </div>
          
          <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="agree" style="border-radius: 4px; border: 1.5px solid #505050" required>
                <span class="ml-2 text-sm">By clicking process payment, you agree with  our 
                    <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                        Terms and Conditions
                    </a> 
                </span>
            </label>
        </div>
          
        <div class="button-section mt-4 mb-4">
            <button type="submit" class="buttons text-center" style="border: none; border-radius: 8px">
                Process the order
            </button>
        </div>
          
        </div>
      
        <div class="card-form">
        @csrf
            
      	<div class="mt-3">
        <input id="momochk" type="radio" name="payment_method" value="cc" checked hidden>
            <x-input-error :messages="session('phone')" class="mt-2 text-left" />
        </div>
        
        <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="agree" style="border-radius: 4px; border: 1.5px solid #505050">
                <span class="ml-2 text-sm">By clicking process payment, you agree with  our 
                    <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                        Terms and Conditions
                    </a> 
                </span>
            </label>
        </div>

        <div class="button-section action-btns mt-4 mb-4">
            <button type="submit" class="buttons text-center" style="border: none; border-radius: 7px">
                Click to Proceed
            </button>
        </div>

    </div>

    </div>

        </div>

      
                    </form>
                </div>
            </div>
            </div>

            
  	<script>
      
      const doorStep = document.getElementById('doorStep');
    const pickUp = document.getElementById('pickUp');

    doorStep.addEventListener('click', function () {
        document.getElementById('dStep').checked = true;
        document.getElementById('delivery_address').style.display = 'block';
    });

    pickUp.addEventListener('click', function () {
        document.getElementById('pick').checked = true;
        document.getElementById('delivery_address').style.display = 'none';
    });

      const momobtn = document.getElementById('momobtn');
      const momochk = document.getElementById('momochk');
       const visabtn = document.getElementById('visabtn');
      const visachk = document.getElementById('visachk');
   
       const phoneForm = document.querySelector('.phone-form');
       const cardForm = document.querySelector('.card-form');
       const confirm = document.querySelector('.confirm');
   
       window.onload = function() {
       momobtn.style.border = "2px solid";
       momochk.checked = true;
       phoneForm.style.display = 'block';
       confirm.style.display = 'block';
     };
   
   visachk.addEventListener('change', function() {
     visabtn.style.border = "2px solid";
   });
   
       momobtn.addEventListener('click', function() {
       momochk.checked = true;
       momobtn.style.border = "2px solid";
       visabtn.style.border = "1px solid";
       phoneForm.style.display = 'block';
       cardForm.style.display = 'none';
       confirm.style.display = 'block';
     });
   
   visabtn.addEventListener('click', function() {
      visachk.checked = true;
      momobtn.style.border = "1px solid";
     visabtn.style.border = "2px solid";
         phoneForm.style.display = 'none';
        cardForm.style.display = 'block';
         confirm.style.display = 'block';
       });
     
 </script>

</x-ht-clt-layout>