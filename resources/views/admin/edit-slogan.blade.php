@section('title', 'Slogan')

<x-ht-admin-layout>
<div class="body d-flex justify-content-center">

<div class="col-lg-7 p-2 mt-3 mb-5">

    <div class="w-full">
        <div class="w-full">
            <form action="{{ route('admin.edit-slogan-info') }}" method="post" enctype="multipart/form-data">
            @csrf
                <h2 class="form-title-sub">Edit slogan info</h2>

                <input type="hidden" name="slogan" value="{{ $slogan->id }}">

                <div class="mt-4">
                    <label for="name" class="w-full fw-500">Slogan</label>
                    <input class="w-full" type="text" name="headline" placeholder="Enter poster name" value="{{ $slogan->headline }}" required>
                </div>

                <div class="mt-3">
                    <label for="desc" class="w-full fw-500">Description</label>
                    <textarea name="desc" id="" cols="30" rows="2" class="w-full radius" placeholder="Enter description" required> {{ $slogan->description }} </textarea>
                </div>

            </div>

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
        function loadFile(event) {
        var output = document.querySelector('#output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        };
    }

    </script>

</x-ht-admin-layout>