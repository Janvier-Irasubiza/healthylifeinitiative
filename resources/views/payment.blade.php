<x-payment-layout>
    
<div class="mt-4 px-3">

<div class="alert alert-warning mb-4 d-flex justify-content-between align-items-center" role="alert">
  <p class="m-0 f-14">This is an invoice for your order. check it out!</p>
  <div class="m-0 d-flex gap-2 align-items-center">
    <p class="m-0 f-12 fw-500">Due By:</p>
    <p class="m-0 f-12 fw-500">{{ $client->due_date }}</p>
    </div>
</div>

    <div class="date">
        <p class="m-0">
            <strong class="f-13">
               Issue Date: {{ $client->requested_on }}
            </strong>
        </p>
    </div>
    <div class="flex-section justify-content-between">
        <div>
            <h4 class="mb-3 form-title-sub f-16">Invoice to</h4>
            <div>
                <p class="form-title-sub m-0 f-15"> {{ $client->client_names }}</p>
                <p class="m-0 f-14">{{ $client->client_email }}</p>
                <p class="m-0 f-14">{{ $client->client_phone }}</p>
            </div>
        </div>
        <div class="inv-from">
        <h5 class="mb-3 form-title-sub">Invoice from</h5>
            <div>
                <p class="m-0 form-title-sub f-15">Healthy Life initiative</p>
                <p class="m-0 f-14">healthylifeinitiative2024@gmail.com</p>
                <p class="m-0 f-14">+250 793 083 966</p>
            </div>
        </div>
    </div>

    <div class="mt-4 border rounded p-2">
    <p class="m-0 f-14 fw-500">
       <span class="cap"> Order number: </span>
            <strong class="">
                {{ $client->order_number }}
            </strong>
        </p>
    </div>

    <div class="mt-4 wrapper">
    <table class="w-full table">
                <thead>
                    <tr>
                        <th class="cap muted-text f-12">Quantity</th>
                        <th class="cap muted-text f-12">Product</th>
                        <th class="text-right cap muted-text f-12">Price</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($products as $key => $product)
                    <tr style="border-bottom: 1px solid #ddd">
                        <td class="px-4 f-13">
                            {{ $orderInfo[$key]->quantity }}
                        </td>
                        <td class="f-13">
                            {{ $product->name }}
                        </td>
                        <td class="text-right f-13">
                            <strong>
                              @if(!is_null($product->promo_price))
                            	{{ number_format($product->promo_price * $orderInfo[$key]->quantity) }}
                              @else 
                              	{{ number_format($product->price * $orderInfo[$key]->quantity) }}
                              @endif
                              RWF
                            </strong>
                        </td>
                    </tr>
                  @endforeach
                </tbody>

            </table>
            
    </div>

    <div class="sm-pyt-wrapper w-full gap-2 mt-4">

           @foreach($products as $key => $product)
            <div class="order-desc w-full px-2 py-2 mt-1 mb-2 pb-0 border rounded border-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="w-full">
                        <div class="w-full d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <p class="fw-500 f-18">{{ $product->name }}</p>
                                <div>
                                    <label class="f-18" style="position: relative; top: 0px"><small style="font-weight: 500">
                                      @if(!is_null($product->promo_price))
                                        {{ number_format($product->promo_price * $orderInfo[$key]->quantity) }}
                                      @else 
                                        {{ number_format($product->price * $orderInfo[$key]->quantity) }}
                                      @endif
                                      RWF
                                      </small></label><br>
                                </div>
                            </div>
                            <div class="" style="padding: 0px 5px">
                                <span class="fw-500 f-14">Qty:</span>  <strong class="f-13">{{ $orderInfo[$key]->quantity }}</strong><br>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
      				@endforeach

            </div>

    <div class="mt-5">
        <table class="w-full table">
            <thead>
                <tr>
                    <th class="cap muted-text f-12">
                        Payment Info
                    </th>
                    <th class="muted-text cap f-12">
                        Due by
                    </th>
                    <th class="muted-text cap f-12 text-right">
                        Total Due
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-3">
                        <p class="f-13">MoMo Pay: <strong>05452</strong></p> 
                        <p class="f-13">Phone number: <strong>+250 785 543 234</strong></p> 
                    </td>
                    <td class="py-3">
                    <p class="f-13">
                        <strong>{{ $client->due_date }}</strong>
                    </p> 
                    </td>
                    <td class="py-3 text-right f-13">
                        <strong>
                          {{ number_format($totalDue) }} RWF 
                      </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  
  <div class="alert alert-warning mt-4 d-flex justify-content-between align-items-center" role="alert">
  <p class="m-0 f-14">Please share us a screenshot after payment.</p>
  <div class="m-0 d-flex gap-2 align-items-center">
    <p class="m-0 f-12 fw-500">Whatsapp number: +250 793 083 966</p>
    </div>
</div>

</div>
    
</x-payment-layout>
