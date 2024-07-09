@section('title', 'Products')

<x-ht-admin-layout>

<div class="body px5 py-4 mb-5">

<div class="d-flex justify-content-between mb-2">
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

  <div class="scrl-table">
<table class="w-full mt-2" id="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>In stock</th>
                    <th>Unit price</th>
                    <th class="text-center">Likes</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key => $product)
                <tr style="border-bottom: 1px solid #ddd">
                    <td>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="item-img" style="border: none   ">
                                <img src="{{ asset('images/products') }}/{{ $product->poster }}" alt="">
                            </div>
                            <p>{{ $product->name }}</p>
                        </div>
                    </td>
                    <td>{{ $category[$key]->category }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="py-1 px-3" style="color: black; border-radius: 4px 0px 0px 4px; border: 1px solid #ddd; border-right: none"> {{ $product->quantity }} </button>
                            <button type="button" style="color: black; border-radius: 0px 4px 4px 0px; border: 1px solid #ddd;">
                                <i class="fab fa-plus dropdown-toggle-split" aria-haspopup="true"></i>
                            </button>
                            
                        </div>
                        <div class="dpn">
                            <div class="dp-div border transparent p-2 mt-1">
                                <form action="{{ route('admin.add-items') }}" method="post"> @csrf
                                    <label for="" class="fw-500">Add items</label>
                                    <div class="d-flex gap-1">
                                        <input type="hidden" value="{{$product->id}}" name="product" class="w-full">
                                        <input type="text" name="quantity" placeholder="Enter a number" required class="w-full">
                                        <button type="submit" class="buttons px-3">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="m-0">{{ number_format($product->price) }} RWF</p>
                        @if($product->promo_price)
                        <small>{{number_format($product->promo_price)}}</small> &nbsp; <a href="{{ route('admin.un-promote', ['product'=>$product->id]) }}" style="font-size: 11px; padding: 5px 10px" class="bg-success badge rounded" href="">Undo</a>
                        @else
                        <button style="font-size: 11px; padding: 5px 10px" class="bg-success badge rounded pmt" href=""> Promote</button>

                        <div class="pmt-dpn">
                            <div class="pmt-dp-div border transparent p-2 mt-1">
                                <form action="{{ route('admin.promote') }}" method="post"> @csrf
                                    <label for="" class="fw-500">Promotion price</label>
                                    <div class="d-flex gap-1">
                                        <input type="hidden" name="product" value="{{ $product->id }}" class="w-full">
                                        <input type="text" name="promo_price" placeholder="Enter price" required class="w-full">
                                        <button type="submit" class="buttons px-3">Promote</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $product->like_count }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.edit', ['product'=>$product->uuid]) }}" class="">
                            <i class="fa-solid fa-edit"></i>
                        </a>

                        <a href="{{ route('admin.delete-prod', ['product'=>$product->id]) }}" class="delete-btn ml-2">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    </div>
</x-ht-admin-layout>