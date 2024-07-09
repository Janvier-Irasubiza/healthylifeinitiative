@section('title', 'Orders')

<x-ht-admin-layout>

<div class="body mb-5 px-4 py-1">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="true"> Active Requests</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="processing-tab" data-bs-toggle="tab" data-bs-target="#processing" type="button" role="tab" aria-controls="processing" aria-selected="false"> In-Process</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="false"> Special Orders</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
        
        <div class="wrapper">
                <table class="table align-middle mt-1 border border-transparent rounded" id="table" style="border-radius: 7px; border: none">
                    <thead class="bg-light">
                        <tr style="border: 1px solid red">
                            <th class="fw-500">Client</th>
                            <th class="fw-500">Product requested</th>
                            <th class="fw-500">Quantity</th>
                            <th class="fw-500   ">Delivery option</th>
                            <th class="text-center fw-500">Payment status</th>
                            <th class="text-center fw-500">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="" >
                                <p class="fw-500">{{ $order->client_names }}</p>
                                <div>
                                    <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone}}</small></label><br>
                                    <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                                </div>
                            </td>
                            
                            <td>
                                <p class="fw-normal fw-500">{{ $order->product_name}}</p>
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center" style="margin: 0px">
                                    <div class="" style="padding: 0px 5px">
                                        <span class="">{{ $order->ordered_quantity }} {{ $order->quantity_unit }}@if($order->quantity_unit > 1 && $order->quantity_unit != 'kg')s @endif</span><br>
                                        <small class="">({{ number_format($order->product_price)}} * {{ $order->ordered_quantity}})</small>
                                    </div>
                                </div>
                            </td> 
                            
                            <td class="">
                                {{ $order->delivery_mode}}
                            </td>

                            <td class="text-center">
                                <div class="w-full">
                                    <div class="continue-app d-flex align-items-center justify-content-center p-1" style="">
                                        <div class="staff-resume-btn-1">
                                            <span class="fw-500">{{ number_format($order->product_price*$order->ordered_quantity)}} RWF</span> <br>
                                            @if($order-> payment_status == "Paid")
                                            <span class="badge bg-success py-1 px-3">{{ $order-> payment_status}}</span>
                                            @else
                                            <span class="badge bg-warning py-1 px-3">{{ $order-> payment_status}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                @if($order-> progress == 'Completed')
                                    <span class="badge bg-success py-1 px-3">{{ $order-> progress}}</span> &nbsp;
                                @else 
                                    <a href="{{ route('admin.order', ['order' => $order->order_uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                        Process
                                    </a>
                                @endif
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="sm-wrapper w-full gap-2">

            @foreach($orders as $order)
            <div class="order-desc w-full px-2 py-2 mt-1 mb-2 pb-0 border rounded border-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="w-full">
                        <div class="w-full d-flex justify-content-between">
                            <div>
                                <p class="fw-500">{{ $order->client_names }}</p>
                                <div>
                                    <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone }}</small></label><br>
                                    <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                                </div>
                            </div>
                            <div class="" style="padding: 0px 5px">
                                <span class="">{{ $order->ordered_quantity }} {{ $order->quantity_unit }}@if($order->quantity_unit > 1 && $order->quantity_unit != 'kg')s @endif</span><br>
                                <small class="">({{ number_format($order->product_price)}} * {{ $order->ordered_quantity}})</small>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3  mb-2">
                        <div class="w-full">
                            <div class="">
                                <p class="c-head mb-0" style="font-weight:500">{{ $order->product_name}}</p>
                            </div>
                            <div class="">
                                <p class="text-muted"><small style="font-size: 11px;">{{ $order->requested_on}}</small></p>
                            </div>
                        </div>

                        <div class="w-full text-right">
                            <div class="">

                            @if($order-> progress == 'Completed')
                                    <span class="badge bg-success py-1 px-3">{{ $order-> progress}}</span> &nbsp;
                                @else 
                                    <a href="{{ route('admin.order', ['order' => $order->order_uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                        Process
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        
        <div class="tab-pane fade show" id="processing" role="tabpanel" aria-labelledby="processing-tab">
        <div class="wrapper">
        <table class="table align-middle mb-0 bg-white mt-1 border border-transparent rounded" id="table" style="border-radius: 7px; border: none">
            <thead class="bg-light">
                <tr>
                <th class="fw-500">Client</th>
                <th class="fw-500">Product requested</th>
                <th class="fw-500">Location</th>
                <th class="fw-500">Processed</th>
                <th class="text-center fw-500">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($inProcessOrders as $order)
                <tr>
                    <td>
                        <p class="fw-500">{{ $order->client_names }}</p>
                        <div>
                            <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone }} </small></label><br>
                            <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                        </div>
                    </td>

                    <td class="">
                        <p class="fw-normal">{{ $order->product_name}}</p>
                    </td>
                    
                    <td>
                        <div class="d-flex align-items-center" style="margin: 0px">
                        <div class="" style="padding: 0px 5px">
                            <p name="messade" id="" cols="30" rows="10">
                                @if($order->delivery_city)
                                    {{ $order->delivery_city }},
                                @endif 
                                @if($order->delivery_sector)
                                    {{ $order->delivery_sector }},
                                @endif
                                @if($order->delivery_cell)
                                    {{ $order->delivery_cell }},
                                @endif 
                                @if($order->delivery_vilage)
                                    {{ $order->delivery_vilage }},
                                @endif 
                                @if($order->delivery_description)
                                    {{ $order->delivery_description }}
                                @endif
                            </p>
                        </div>
                        </div>
                    </td>
                    
                    <td>
                            <p name="messade" id="" cols="30" rows="10">{{ $order->processed_on }}</p>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.complete-order', ['order' => $order->order_uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                            Complete
                        </a>
                    </td>
                </tr>

                @endforeach
            </tbody>
            </table>
        </div>

        <div class="sm-wrapper w-full gap-2">
        @foreach($spclOrders as $order)
            <div class="order-desc w-full px-2 py-2 mt-1 mb-2 pb-0 border rounded border-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="w-full">
                        <div class="w-full d-flex justify-content-between">
                            <div>
                                <p class="fw-500">{{ $order->client_names }}</p>
                                <div>
                                    <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone }}</small></label><br>
                                    <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3  mb-2">
                        <div class="w-full">
                            <div class="">
                                <p class="c-head mb-0" style="font-weight:500">{{ $order->product}}</p>
                                <p class="text-muted"><small style="font-size: 11px;">@if(strlen($order->description) > 10){{ substr($order->description, 0, 10)}}...@else {{ $order->description}} @endif</small></p>
                            </div>
                            <div class="">
                                <p class="text-muted"><small style="font-size: 11px;">{{ $order->request_date}}</small></p>
                            </div>
                        </div>

                        <div class="w-full text-right">
                            <div class="">
                                <a href="{{ route('admin.special-order', ['order' => $order->uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                    Complete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
        </div>

        <div class="tab-pane fade show" id="requests" role="tabpanel" aria-labelledby="requests-tab">
        <div class="wrapper">
        <table class="table align-middle mb-0 bg-white mt-1 border border-transparent rounded" id="table" style="border-radius: 7px; border: none">
            <thead class="bg-light">
                <tr>
                <th class="fw-500">Client</th>
                <th class="fw-500">Product requested</th>
                <th class="fw-500">Description</th>
                <th class="text-center fw-500">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($spclOrders as $order)
                <tr>
                    <td>
                        <p class="fw-500">{{ $order->client_names }}</p>
                        <div>
                            <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone }} </small></label><br>
                            <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                        </div>
                    </td>

                    <td class="">
                        <p class="fw-normal">{{ $order->product}}</p>
                    </td>
                    
                    <td>
                        <div class="d-flex align-items-center" style="margin: 0px">
                        <div class="" style="padding: 0px 5px">
                            <p name="messade" id="" cols="30" rows="10">@if(strlen($order->description) > 30){{ substr($order->description, 0, 30)}}...@else {{ $order->description}} @endif</p>
                        </div>
                        </div>
                    </td> 

                    <td class="text-center">
                                 @if($order->status == 'In process')
                                    <span class="badge bg-warning py-1 px-3">{{ $order-> status}}</span> &nbsp;

                                    <a href="{{ route('admin.complete-special-order', ['order' => $order->id]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                        Complete
                                    </a>
                                @elseif($order->status == 'Completed')
                                    <span class="badge bg-success py-1 px-3">{{ $order-> status}}</span> &nbsp;
                                @else
                                    <a href="{{ route('admin.special-order', ['order' => $order->uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                        Process
                                    </a>
                                @endif
                    </td>
                </tr>

                @endforeach
            </tbody>
            </table>
        </div>

        <div class="sm-wrapper w-full gap-2">
        @foreach($spclOrders as $order)
            <div class="order-desc w-full px-2 py-2 mt-1 mb-2 pb-0 border rounded border-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="w-full">
                        <div class="w-full d-flex justify-content-between">
                            <div>
                                <p class="fw-500">{{ $order->client_names }}</p>
                                <div>
                                    <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $order->client_phone }}</small></label><br>
                                    <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $order->client_email }}</small></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3  mb-2">
                        <div class="w-full">
                            <div class="">
                                <p class="c-head mb-0" style="font-weight:500">{{ $order->product}}</p>
                                <p class="text-muted"><small style="font-size: 11px;">@if(strlen($order->description) > 10){{ substr($order->description, 0, 10)}}...@else {{ $order->description}} @endif</small></p>
                            </div>
                            <div class="">
                                <p class="text-muted"><small style="font-size: 11px;">{{ $order->request_date}}</small></p>
                            </div>
                        </div>

                        <div class="w-full text-right">
                            <div class="">
                            
                                @if($order->status == 'In process')
                                <span class="badge bg-warning py-1 px-3">{{ $order-> status}}</span> &nbsp;

                                <a href="{{ route('admin.special-order', ['order' => $order->id]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                    Complete
                                </a>
                                @else
                                <a href="{{ route('admin.special-order', ['order' => $order->uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                    Process
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
        </div>
    </div>
</div>

</x-ht-admin-layout>