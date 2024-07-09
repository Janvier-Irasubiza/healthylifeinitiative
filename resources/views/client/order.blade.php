@section('title', 'Home')

<x-ht-clt-layout>
    <div class="body">

            <div class="mt-3 py-4 text-center">
            <h2 class="form-title-cst">Make a special order</h2>
            </div>
            
            <div class="d-flex justify-content-center">

            <div class="mb-5 col-lg-6" style="border: 1px solid #bbb; border-radius: 7px">
            <form action="{{ route('client.special-order') }}" method="POST">
            @csrf
            <div class="flex-section justify-content-center">
                <div class="w-full p-4">
                        <h2 class="form-title-sub">Product description</h2>
                        <div class="mt-3">
                            <label for="" class="w-full">Product</label>
                            <input class="w-full" type="text" name="product" placeholder="Enter product name" autofocus required>
                        </div>

                        <div class="mt-4">
                            <label for="" class="w-full">Product description</label>
                            <textarea class="w-full" name="desc" placeholder="Describe your product here" required></textarea>
                        </div>
      
                </div>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" class="buttons" style="font-weight: 500;"> SUBMIT </button>
                </div>

                </form>
            </div>

            </div>
            </div>

</x-ht-clt-layout>
