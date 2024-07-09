@section('title', 'Order Info')

<x-ht-admin-layout>
    <div class="body mb-5 d-flex justify-content-center">
        <div class="order-info">
            
        <div class="mt-4 py-2">
            <h2 class="form-title-sub">Order information</h2>
            </div>
            
            <div class="mb-5 border border-transparent p-2" style="border-radius: 7px">
            <div class="">

                <div class="w-full p-2">
                <div class="flex gap-3 mb-2">

                        <div class="">
                            <h1 class="product-name" >{{ $order -> product }}</h1>
                        </div>
                  		</div>

                            <div class="d-flex justify-content-between">
                  				<div style="" >
                                    <p class="c-name fw-500" style="font-weight: 500"> {{ $order->description }} </p>

                                </div>

                                <div class="text-center py-2">
                                  <!-- <a style="font-weight: bold; color: ghostwhite; font-size: 12px" class="text-sm py-1 px-3 mt-1 bg-success text-gray-600 dark:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                                          {{ __('Request to pay') }}
                                       </a> -->
                                </div> 
                  			</div>
                    
                    </div>
                
                </div>
              
              <div class="px-2">
                <p class="m-0 off-price mb-2">Order received on: {{ $order -> request_date }}</p>
              </div>
      
                <div class="w-full p-2 mt-2 mb-2">
                    <h2 class="form-title-sub">Contact information</h2>
                    <div class="flex-section justify-content-between align-items-center mt-3">
                        <div class="w-full">
                            <p for="" class="w-full fw-500 mb-2">Personal Info</p>
                            <div class="disp-text">
                                <label class="mb-1 fw-500 w-full dt-item-1">{{ $order->client_names }}</label>
                            </div>
                            <div class="disp-text">
                                <label class="w-full mb-1 dt-item-2"><small style="font-weight: 500">Phone: {{ $order->client_phone }}</small></label>
                            </div>
                            <div class="disp-text">
                                <label class="w-full mb-1 dt-item-3"><small style="font-weight: 500">Email: &nbsp;  {{ $order->client_email }}</small></label>
                            </div>
                        </div>

                        <div class="w-full add-cont">                            
                            @if($order-> status == 'pending')
                                <button class="buttons mt-1 px-3 py-1" data-bs-toggle="modal" data-bs-target="#approveOrder"><strong style="font-size: 10px">APPROVE ORDER</strong></button>
                                <button class="mod-btn mt-1 px-3 py-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><strong style="font-size: 10px">DENY ORDER</strong></button>
                            @elseif($order-> status == 'Denied')
                                <span class="badge bg-warning py-1 px-3">{{ $order-> status}}</span> &nbsp;
                                <a style="font-weight: bold" class="text-danger text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.undo-deny-order', ['order' => $order -> id]) }}">
                                    {{ __('Undo') }}
                                </a>
                            @elseif($order-> status == 'Completed')
                                <span class="badge bg-success py-1 px-3">{{ $order-> status }}</span>
                            @else
                                <span class="badge bg-warning py-1 px-3">{{ $order-> status }}</span> &nbsp;
                                <a href="{{ route('admin.complete-special-order', ['order' => $order->id]) }}" class="primary-btn" style="font-size: 10px">
                                  Complete
                                </a> &nbsp;
                                <button class="mod-btn mt-1 px-3 py-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><strong style="font-size: 10px">DENY ORDER</strong></button>
                            @endif

                        </div>
                    </div>
                </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title c-name" id="staticBackdropLabel">Reason for denying an order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.deny-spcl-order') }}" method="post"> @csrf
                        <input type="hidden" name="order" value="{{ $order->id }}">
                        <div class="modal-body">
                            <textarea class="w-full rounded" name="deny_reason" id="deny-reason" rows="3" placeholder="Enter a reason for denying this order..." required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="buttons px-3 py-1" data-bs-dismiss="modal"><strong style="font-size: 10px">CANCEL</strong></button>
                            <button type="submit" class="px-3 py-1 mod-btn"><strong style="font-size: 10px">DENY ORDER</strong></button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                <!-- </modal> -->

                <!-- Modal -->
                <div class="modal fade" id="approveOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title c-name" id="staticBackdropLabel">Approve order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.spcl-order-approve') }}" method="post"> @csrf

                    <input type="hidden" name="order" value="{{ $order->id }}">

                    <div class="modal-body">
                        <label for="" class="w-full fw-500">Notes about the order</label>
                        <textarea class="w-full rounded" name="notes" id="deny-reason" rows="2" placeholder="Enter notes here" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="px-3 py-1 mod-btn px-3 py-1" data-bs-dismiss="modal"><strong style="font-size: 10px">CANCEL</strong></button>
                        <button type="submit" class="buttons px-3 py-1"><strong style="font-size: 10px">APPROVE ORDER</strong></button>
                    </div>

                    </form>
                    </div>
                </div>
                </div>
                <!-- </modal> -->
            </div>

        </div>
    </div>

</x-ht-admin-layout>