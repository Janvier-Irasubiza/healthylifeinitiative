@section('title', 'Results for {{ $searchQuery }}')

<x-ht-layout>
    <div class="body">
        
    @if(!$results -> isEmpty())
        <div class="mt-3 py-4">
        <h2 class="form-title-cst">Results for "{{ $searchQuery }}"</h2>
        </div>
        
        <div class="mb-5 px-3 py-3" style="border: 1px solid #bbb; border-radius: 7px">
            
            @foreach($results as $result)
                <div class="result w-full border rounded px-2 py-2 mb-2" >
                    @php
                        $ctgr = DB::table('categories') -> where('id', $result -> category) -> first();
                    @endphp

                    <div class="w-full mb-3" style="background-color: #ffffff5b;">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="c-head" style="font-size: 30px"> {{ $result -> name }} </h5>
                                <h6 style="border: 2px solid #000; padding: 3px 10px; border-radius: 5px; font-weight: 450"> {{ $ctgr -> category}} </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-3 mt-2">{{ $result -> description }}</p>
                            <a href="{{ route('product', ['product' => $result->uuid]) }}" class="buttons px-3 py-1" style="font-size: 15px; color: white">Learn More <i style="font-size: 13px" class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
           
        </div>
    @else
        <div class="mt-3 py-4" style="margin-bottom: 155px">
            <h2 class="form-title-cst">Results for "{{ $searchQuery }}": Not found</h2>
        </div>
    @endif
    </div>

</x-ht-layout>