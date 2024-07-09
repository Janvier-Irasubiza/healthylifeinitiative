@section('title', 'Dashboard')

<x-ht-admin-layout>
    <div class="w-full pd mb-5">
        <div class="d-flex justify-content-between">
            <h1 class="c-name py-2">Products</h1>
            <div class="gap-3 justify-content-end add-btns">
                <a href="{{ route('admin.post') }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                    <div>CREATE NEW PRODUCT</div>
                </a>

                <a href="{{ route('admin.add-category') }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                    <div>ADD NEW CATEGORY</div>
                </a>
            </div>
          
          <div class="sm:items-center sm:ms-6 sm-add-btns">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                      <i class="fa fa-bars"></i>
                                  </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.post')" style="font-size: 12px" class="fw-500">
                                    {{ __('CREATE NEW PRODUCT') }}
                                </x-dropdown-link>

                               <x-dropdown-link :href="route('admin.add-category')" style="font-size: 12px" class="fw-500">
                                    {{ __('ADD NEW CATEGORY') }}
                                </x-dropdown-link>
                                
                            </x-slot>
                        </x-dropdown>
                    </div>
          
        </div>

        <div class="category-slider gap-2">
            @foreach($categories as $key => $category)

            <a href="{{ route('admin.edit-category', ['category'=>$category->slag, 'c'=>$category->uuid]) }}">
            <div class="order-desc w-full px-3 py-2 mt-1 pb-0 border border-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-3">
                        <div class="">
                            <i class="fa-solid fa-layer-group"></i>                          
                        </div>
                        <h1 class="c-name" style="font-weight:500">{{$category->category}}</h1>
                        </div>
                        <a href="{{ route('admin.post-by-category', ['category'=>$category->uuid]) }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                            <div>NEW</div>
                        </a>
                    </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <div class="w-full">
                        <div class="">
                            <p class="c-head mb-0" style="font-weight:500">In Stock: {{number_format(count($products[$key]))}} Items</p>
                        </div>
                        <div class="">
                            <p><small style="font-size: 11px; font-weight: 500">{{number_format(count($sales[$key]))}} Sales were made today!</small></p>
                        </div>
                    </div>

                    <div class="w-full text-right">
                        <div class="">
                            <p class="mb-0 align-items-center">
                                <small style="font-size: 12px; font-weight: 500; font-size: 15px">
                            
                                @if(isset($percentageIncrease[$key]))
                                    {{ round($percentageIncrease[$key], 2) }}% 
                                    @if($percentageIncrease[$key] > 0)
                                        <span style="color: #29a329; font-weight: 500; font-size: 14px"><i class="fa-solid fa-arrow-up"></i></span>
                                    @elseif($percentageIncrease[$key] < 0)
                                        <span style="color: #e63333; font-weight: 500; font-size: 14px"><i class="fa-solid fa-arrow-down"></i></span>
                                    @else
                                        <span style="color: #6d7878; font-weight: 500; font-size: 14px"><i class="fa-solid fa-arrow-right"></i></span>
                                    @endif
                                @endif

                            </small>
                        </p>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            @endforeach
        </div>

        <div class="mt35">
            <div class="d-flex justify-content-between align-items-center">
            <h1 class="c-name py-2">Active Requests</h1>
            <p class="c-name py-2" style="font-size: 17px">{{number_format(count($orders))}} Orders</p>
            </div>
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
                                <a href="{{ route('admin.order', ['order' => $order->order_uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                    Process
                                </a>
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
                                <a href="{{ route('admin.order', ['order' => $order->order_uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                    Process
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <div class="mt30">
        <div class="d-flex justify-content-between align-items-center">
                <h1 class="c-name py-2">Special Orders</h1>
            <p class="c-name" style="font-size: 17px">{{number_format(count($spclOrders))}} Orders</p>
            </div>
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
                        <a href="{{ route('admin.special-order', ['order' => $order->uuid]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                Process
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
                                    Process
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
        </div>
    </div>
</x-ht-admin-layout>