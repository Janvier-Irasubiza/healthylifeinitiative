@section('title', $productInfo['name'] )

<x-ht-layout>
    <div class="body">
    
        <div class="path mt-1 mb-2">
            {{ $ctgr -> category }} / {{ $productInfo['name'] }} / Order
        </div>

        <form action="{{ route('make-order') }}" method="POST"> @csrf

        <input class="w-full" type="hidden" name="product_id" value="{{ $productInfo['id'] }}">

        <div class="product-info mb-5">
            <div class="w-full">
            <div class="img-cont-cst">
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic1'] }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic2'] }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic3'] }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic4'] }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic5'] }}" alt="">
                </div>
                <div class="item-img">
                    <img src="{{ asset('images/products') }}/{{ $productInfo['pic6'] }}" alt="">
                </div>
            </div>
            <div class="desc mt-2">
                    <h2 class="item-name">
                        {{ $productInfo['name'] }}
                    </h2>

                    <p class="product-short-desc">
                        {{ $productInfo['description'] }}
                    </p>

                   <div class="prod-det mt-2 rounded">
                        <strong>More bout {{ $productInfo['name'] }}</strong>
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

                    <input type="hidden" name="quantity" value="{{ $productInfo['quantity'] }}">

                    @if(!is_null($productInfo['promo_price'] ))

                    <p class="price mt-3">
                        {{ number_format($productInfo['price']) }} RWF
                    </p>

                    <input type="hidden" name="price" value="{{ $productInfo['promo_price'] }}">

                    <p class="m-0 off-price"><span>{{ number_format($productInfo['unit_price'] * $productInfo['quantity']) }} </span> &nbsp; Save &nbsp; {{ number_format(($productInfo['unit_price'] * $productInfo['quantity']) - ($productInfo['promo_price'] * $productInfo['quantity'])) }} RWF </p>
                    @else
                    <p class="price mt-3">
                        {{ number_format($productInfo['price']) }} RWF
                    </p>

                    <input type="hidden" name="price" value="{{ $productInfo['price'] }}">

                    <p class="m-0 off-price"><small> {{ $productInfo['motive'] }} </small></p>
                    @endif

                </div>
            </div>
            
            <div class="item-cont-cst mb-4 w-full d-flex justify-content-center">
                <div class="w-full px-5">

                    <h2 class="form-title">Confirm your order</h2>

                    <div class="mt-4">
                        <label for="" class="w-full">Names</label>
                        <input class="w-full" type="text" name="names" placeholder="Enter your names" autofocus required>
                        <x-input-error :messages="$errors->get('names')" class="mt-2" />
                    </div>

                    <div class="flex-section mt-2 gap-3">
                        <div>
                            <label for="" class="w-full">Email address</label>
                            <input class="w-full" type="text" name="email" placeholder="Enter your email address" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="" class="w-full">Phone number</label>
                            <input class="w-full" type="text" name="phone" placeholder="Enter your phone number" required>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                    
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
            	<button type="button" id="momobtn" class="col-lg-8 w-full p-1 paybtn">
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
            <input id="phone" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" placeholder="Phone number"  autocomplete="phone_number"/>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-left" />
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
        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-left" />
        </div>
        
        <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="agree" style="border-radius: 4px; border: 1.5px solid #505050" >
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

      
                </div>
            </div>

            </form>


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
