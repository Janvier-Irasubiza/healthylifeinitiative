@section('title', 'Client details')

<x-ht-admin-layout>

<div class="body d-flex justify-content-center">

<div class="order-info flex-section gap-3">
    
<div class="w-full p-2">

<div class="w-full p-3 rounded mt-4 border border-transparent">
        <h2 class="form-title-sub">Client information</h2>
        <div class="flex-section justify-content-between align-items-center mt-4">
            <div class="w-full">

                <p class="fw-500 mb-1">{{ $client->name }}</p>
                <p class=" mb-1"><small style="font-weight: 500"><i class="fa-solid fa-phone"></i> {{ $client->phone }} </small></p>
                <p class=" mb-1"><small style="font-weight: 500"><i class="fa-solid fa-envelope"></i> {{ $client->email }} </small></p>
            </div>

            <div class="w-full">
                <!-- <p class=" mb-1"><small style="font-weight: 500"><i class="fa-solid fa-location-dot"></i> KG 19 Avenue, Kigali</small></p> -->
                <p class=" mb-1"><small style="font-weight: 500">Client since {{ $client->created_at }} </small></p>
            </div>
        </div>
    </div>

</div>

<div class="w-full mt-4 p-2 mb-5">
<h2 class="form-title-sub">
    Orders
</h2>

@foreach($orders as $order)
<a href="{{ route('admin.order', ['order' => $order->order_uuid]) }}">
<div class="border border-transparent w-full p-2 mt-3 rounded">
                
                <div class="d-flex gap-3">
    
                    <div class="w-full">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <h1 class="c-head" >{{ $order->product_name }}</h1>
                        </div>

                        <div class="w-full d-flex justify-content-between mt-2">
                        <div>
                            <div style="">
                                <p class="" style="font-weight: 500"> Delivery: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order->delivery_mode }}</small>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div style="">
                                <p class="" style="font-weight: 500"> Status: </p>
                                <div style="top: 22px; display: flex; gap: 5px">
                                    <small class="text-sm w-full" style="position: relative">{{ $order->progress }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>

                </div>
                
            </div>
            </a>
            @endforeach
</div>

</div>

</x-ht-admin-layout>