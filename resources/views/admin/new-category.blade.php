@section('title', 'Create new category')

<x-ht-admin-layout>
<div class="body d-flex justify-content-center">

<div class="col-lg-7 p-2 mt-3 mb-5">

    <div class="w-full">
        <div class="w-full">
            <form action="{{ route('admin.create-category') }}" method="post" enctype="multipart/form-data"> @csrf
                <h2 class="form-title-sub">Create new category</h2>
                <div class="mt-4 w-full">
                    <label for="" class="w-full fw-500">Category name</label>
                    <input class="w-full mt-2" type="text" id="productName" name="category" value="{{ old('category') }}" placeholder="Enter product name" autofocus required>
                    <input class="w-full" type="hidden" name="slag" id="slag" value="{{ old('slag') }}" placeholder="Enter product name" required>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                <x-input-error class="mt-2" :messages="$errors->get('slag')" />

                <div class="mt-3">
                    <label for="" class="w-full fw-500">Poster</label>
                    <div class="d-flex gap-2">
                        <div>
                            <div class="">
                                <label for="" class="w-full">
                                    <small class="fw-500">Main image</small>
                                    <div class="text-center">
                                        <div style="position: relative">
                                            <div class="main-img">
                                            <img src="{{ asset('images/img.png') }}" id="output" alt="photo" style="max-width: 100%; max-height: 100%">
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
                                    <small class="fw-500">Banner</small>
                                </label>
                                <div class="d-flex justify-content-between gap-1">
                                    <div class="pdt-side-imgs d-flex justify-content-center">
                                        <div style="position: relative; ">
                                            <img src="{{ asset('images/img.png') }}" alt="photo" id="output1">
                                            <div>
                                                <input class="pdt-sds-poster-ipt" type="file" name="banner" onchange="loadFile1(event)">
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
            </div>
            
            </div>

            <div class="button-section mt-4 mb-4">
                <button type="submit" class="buttons text-center" style="border: none; border-radius: 8px">
                    Add category
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

</script>

</x-ht-admin-layout>