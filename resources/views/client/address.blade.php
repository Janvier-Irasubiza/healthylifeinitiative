@section('title', 'Address' )

<x-ht-clt-layout>
    <div class="body">
    
        <div class="path mt-1 mb-2">
            Category / Order
        </div>

        <form action="{{ route('client.update-order') }}" method="POST"> 
        
        @csrf

        <input class="w-full" type="hidden" name="order_id" value="{{ $order -> id }}">

        <div class="d-flex justify-content-center product-info mb-5">
            
            
            <div class="item-cont-cst mb-4 col-lg-6">
                <div class="w-full px-5">

                        <h2 class="form-title text-center">Give us your address</h2>
                    
                    <div class="mt-4">

                        <div class="mt-3" id="delivery_address">
                            <label for="" class="w-full mt-2">Home address</label>
                            <div class="mb-2">
                                <input class="w-full" type="text" name="city" placeholder="City/District" required>
                            </div>

                            <div class="mb-2">
                                <input class="w-full" type="text" name="sector" placeholder="Sector" required>
                            </div>

                            <div class="mb-2">
                                <input class="w-full" type="text" name="cell" placeholder="Cell" required>
                            </div>

                            <div class="mb-2">
                                <input class="w-full" type="text" name="village" placeholder="Village" required>
                            </div>

                            <textarea name="address_details" id="" rows="1" class="w-full rounded mt-2" placeholder="Describe your neighbourhood" required></textarea>
                        </div>

                            <x-input-error :messages="$errors->get('delivery')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <button type="submit" class="buttons" style="font-weight: 500;"> SUBMIT </button>
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
