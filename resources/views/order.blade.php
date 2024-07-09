@section('title', 'Order')

<x-ht-layout>
    <div class="body">

            <div class="mt-3 py-4">
            <h2 class="form-title-cst">Make a special order</h2>
            </div>
            
            <div class="mb-5" style="border: 1px solid #bbb; border-radius: 7px">
            <form action="{{ route('special-order') }}" method="POST">
            @csrf
            <div class="flex-section justify-content-center gap-4">
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

                <div class="w-full p-4">
                        <h2 class="form-title-sub">Personal information</h2>
                        <div class="mt-3">
                            <label for="" class="w-full">Names</label>
                            <input class="w-full" type="text" name="names" placeholder="Enter your names" autofocus required>
                        </div>

                        <div class="flex-section gap-3">
                            <div class="mt-4"> 
                                <label for="" class="w-full">Email address</label>
                                <input class="w-full" type="text" name="email" placeholder="Enter your email address" required>
                            </div>

                            <div class="mt-4">
                                <label for="" class="w-full">Phone number</label>
                                <input class="w-full" type="text" name="phone" placeholder="Enter your phone number" required>
                            </div>
                        </div>
      
                </div>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" class="buttons" style="font-weight: 500;"> SUBMIT </button>
                </div>

                </form>
            </div>
            </div>

</x-ht-layout>