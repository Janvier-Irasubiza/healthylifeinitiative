@section('title', 'clients')

<x-ht-admin-layout>

<div class="body d-flex justify-content-center">
<div class="order-info p-2 mb-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="home" aria-selected="true"> Waiting clients</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab" aria-controls="profile" aria-selected="false"> Served clients </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active scrl-table" id="orders" role="tabpanel" aria-labelledby="home-tab">
        <table class="w-full mt-2" id="table">
            <thead class="bg-light">
                <tr>
                <th class="fw-500">Client</th>
                <th class="fw-500">Address</th>
                <th class="fw-500">Pending orders</th>
                <th class="text-center fw-500">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pendingClients as $key => $client)
                <tr>
                    <td class="" >
                        <p class="fw-500">{{ $client->client_names }}</p>
                        <div>
                        <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $client->client_phone }}</small></label><br>
                        <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $client->client_email }}</small></label>
                        </div>
                    </td>
                    
                    <td>
                        <p class="fw-normal fw-500">
                            @if($client->delivery_city)
                                {{ $client->delivery_city }},
                            @endif 
                            @if($client->delivery_sector)
                                {{ $client->delivery_sector }},
                            @endif
                            @if($client->delivery_cell)
                                {{ $client->delivery_cell }},
                            @endif 
                            @if($client->delivery_vilage)
                                {{ $client->delivery_vilage }},
                            @endif 
                            @if($client->delivery_description)
                                {{ $client->delivery_description }}
                            @endif
                        </p>
                    </td>

                    <td class="">
                        {{ number_format($client->orders_count) }} Orders
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.client', ['client'=>$client->client_id]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>

        <div class="tab-pane fade show scrl-table" id="requests" role="tabpanel" aria-labelledby="profile-tab">
        <table class="w-full mt-2" id="table">
            <thead class="bg-light">
                <tr>
                <th class="fw-500">Client</th>
                <th class="fw-500">Address</th>
                <th class="fw-500">Served orders</th>
                <th class="text-center fw-500">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($ServedClients as $client)
                <tr>
                    <td>
                        <p class="fw-500">{{ $client->client_names }}</p>
                            <div>
                            <label class="" style="position: relative; top: 0px"><small style="font-weight: 500">{{ $client->client_phone }}</small></label><br>
                            <label class="" style="position: relative; top: -5px"><small style="font-weight: 500">{{ $client->client_email }}</small></label>
                        </div>
                    </td>

                    <td class="">
                        <p class="fw-normal">
                            @if($client->delivery_city)
                                {{ $client->delivery_city }},
                            @endif 
                            @if($client->delivery_sector)
                                {{ $client->delivery_sector }},
                            @endif
                            @if($client->delivery_cell)
                                {{ $client->delivery_cell }},
                            @endif 
                            @if($client->delivery_vilage)
                                {{ $client->delivery_vilage }},
                            @endif 
                            @if($client->delivery_description)
                                {{ $client->delivery_description }}
                            @endif
                        </p>
                    </td>
                    
                    <td>
                        {{ $client->orders_count }} Orders
                    </td> 

                    <td class="text-center">
                        <a href="{{ route('admin.client', ['client'=>$client->client_id]) }}" class="container border border-transparent" style="padding: 2px 20px 3px 20px; border-radius: 4px">
                                View
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
            </table>
        </div>
    </div>
</div>
</div>

</x-ht-admin-layout>