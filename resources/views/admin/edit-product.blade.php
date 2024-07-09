@section('title', 'Publish a product')

<x-ht-admin-layout>
<div class="body d-flex justify-content-center">

<div class="col-lg-7 p-2 mt-3 mb-5">

    <div class="w-full">
        <div class="w-full">
            <form action="{{ route('admin.edit-product') }}" method="post" enctype="multipart/form-data"> @csrf
                <h2 class="form-title-sub">{{$product->name}} - Edit    </h2>
                <div class="mt-4 w-full">
                    <label for="" class="w-full fw-500">Product name</label>
                    <input class="w-full" type="hidden" id="" name="product" value="{{ old('product', $product->id) }}" required>
                    <input class="w-full" type="text" id="productName" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name" autofocus required>
                    <input class="w-full" type="hidden" name="slag" id="slag" value="{{ old('slag', $product->slag) }}" placeholder="Enter product name" required>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                <x-input-error class="mt-2" :messages="$errors->get('slag')" />
                <x-input-error class="mt-2" :messages="$errors->get('type')" />

                <div class="flex-section mt-3 gap-3">
                    <div class="w-full">
                        <label for="" class="w-full fw-500">Product category</label>
                        <select name="category" id="" class="select w-full">
                            @foreach($categories as $category)
                                @if($category->id == $product->category)
                                    <option value="{{$category->id}}" selected>{{$category->category}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->category}}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>

                    <div class="w-full">
                        <label for="" class="w-full fw-500">Quantity</label>
                        <input class="w-full" type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}" placeholder="Enter quantity available" required>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                    </div>
                    
                    <div class="w-full">
                        <label for="" class="w-full fw-500">Unit</label>
                        <input class="w-full" type="text" name="quantity_unit" value="{{ old('quantity_unit', $product->quantity_unit) }}" placeholder="Kg / bottles / Item" required>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity_unit')" />
                    </div>  

                    <div class="w-full">
                        <label for="" class="w-full fw-500">Price</label>
                        <input class="w-full" type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="Enter product price" required>
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                </div>

                <div class="mt-3">
                    <label for="" class="w-full fw-500">Motive</label>
                    <textarea name="motive" id="" cols="30" rows="2" class="w-full radius" placeholder="Motive for this product">{{ old('motive', $product->motive) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('motive')" />
                </div>

                <div class="mt-3">
                    <label for="" class="w-full fw-500">Product description</label>
                    <textarea name="description" id="" cols="30" rows="3" class="w-full radius" placeholder="Describe product here">{{ old('description', $product->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
              
              	<div class="mt-3">
                    <label for="" class="w-full fw-500">Added values</label>
                    <input name="added_value" id="" cols="30" rows="2" class="w-full radius" placeholder="Enter added values here (Separate using comma ',')" value="{{ old('added_value', $product->added_value) }}">
                    <x-input-error class="mt-2" :messages="$errors->get('added_value')" />
                </div>
          
          		<div class="mt-3">
                    <label for="" class="w-full fw-500">Benefits to life</label>
                    <input name="life_benefits" id="" cols="30" rows="2" class="w-full radius" placeholder="Enter benefits to life here (Separate using comma ',')" value="{{ old('life_benefits', $product->life_benefits) }}">
                    <x-input-error class="mt-2" :messages="$errors->get('life_benefits')" />
                </div>

                <div class="mt-3">
                    <label for="" class="w-full fw-500">Product images</label>
                    <div class="d-flex gap-2">
                        <div>
                            <div class="">
                                <label for="" class="w-full">
                                    <small class="fw-500">Main image</small>
                                  	<div class="text-center">
                                        <div style="position: relative">
                                            <div class="main-img">
                                            <img src="{{ asset('images/products') }}/{{$product->poster}}" id="output" alt="photo">
                                            </div>
                                            <div>
                                                <input class="pdt-main-poster-ipt" type="file" name="poster" onchange="loadFile(event)">
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="w-full">
                            <div class="mt-4 pdt-sides pt-0 px-0 py-1 border border-transparent">
                                <label for="" class="w-full px-3">
                                    <small class="fw-500">Sides images</small>
                                </label>
                                <div class="d-flex justify-content-between gap-1 px-2">
                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic1}}" alt="photo" id="output1">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic1" value="{{old('pic1', $product->pic1)}}" onchange="loadFile1(event)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic2}}" alt="photo" id="output2">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic2" value="{{old('pic2', $product->pic2)}}" onchange="loadFile2(event)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic3}}" alt="photo" id="output3">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic3" value="{{old('pic3', $product->pic3)}}" onchange="loadFile3(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic4}}" alt="photo" id="output4">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic4" value="{{old('pic4', $product->pic4)}}" onchange="loadFile4(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic5}}" alt="photo" id="output5">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic5" value="{{old('pic5', $product->pic5)}}" onchange="loadFile5(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/products') }}/{{$product->pic6}}" alt="photo" id="output6">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="pic6" value="{{old('pic6', $product->pic6)}}" onchange="loadFile6(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('poster')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic1')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic2')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic3')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic4')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic5')" />
                <x-input-error class="mt-2" :messages="$errors->get('pic6')" />
            </div>

            <div class="button-section mt-4 mb-4">
                <button type="submit" class="buttons text-center" style="border: none; border-radius: 8px">
                    Save changes
                </button>
            </div>
            </form>
        </div>
    </div>
    </div>

<script>

function generateSlug(input) {
        return input.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
    }

    document.getElementById('productName').addEventListener('input', function() {
        var productName = this.value;
        var slugInput = document.getElementById('slag');
        slugInput.value = generateSlug(productName);
    });

    document.getElementById("type").addEventListener("change", function() {
        var selectValue = this.value;
        var bannerDiv = document.getElementById("bannerDiv");
        if (selectValue === "Slider") {
            bannerDiv.style.display = "block";
        } else {
            bannerDiv.style.display = "none";
        }
    });

    function loadBanner(event) {
        var banner = document.querySelector('#banner');
        banner.src = URL.createObjectURL(event.target.files[0]);
        banner.onload = function() {
            URL.revokeObjectURL(banner.src);
        };
    }

    function loadFile(event) {
        var output = document.querySelector('#output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        };
    }

    function loadFile1(event) {
        var output1 = document.querySelector('#output1');
        output1.src = URL.createObjectURL(event.target.files[0]);
        output1.onload = function() {
            URL.revokeObjectURL(output1.src);
        };
    }

    function loadFile2(event) {
        var output2 = document.querySelector('#output2');
        output2.src = URL.createObjectURL(event.target.files[0]);
        output2.onload = function() {
            URL.revokeObjectURL(output2.src);
        };
    }

    function loadFile3(event) {
        var output3 = document.querySelector('#output3');
        output3.src = URL.createObjectURL(event.target.files[0]);
        output3.onload = function() {
            URL.revokeObjectURL(output3.src);
        };
    }

    function loadFile4(event) {
        var output4 = document.querySelector('#output4');
        output4.src = URL.createObjectURL(event.target.files[0]);
        output4.onload = function() {
            URL.revokeObjectURL(output4.src);
        };
    }

    function loadFile5(event) {
        var output5 = document.querySelector('#output5');
        output5.src = URL.createObjectURL(event.target.files[0]);
        output5.onload = function() {
            URL.revokeObjectURL(output5.src);
        };
    }

    function loadFile6(event) {
        var output6 = document.querySelector('#output6');
        output6.src = URL.createObjectURL(event.target.files[0]);
        output6.onload = function() {
            URL.revokeObjectURL(output6.src);
        };
    }

</script>

</x-ht-admin-layout>