@section('title', 'posting')

<x-ht-admin-layout>

<div class="body d-flex justify-content-center">
<div class="col-lg-8 p-2 mb-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="home" aria-selected="true">Posters</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab" aria-controls="profile" aria-selected="false">Slogan</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="home-tab">

        <div class="d-flex justify-content-between">
            <h1 class="c-name py-2">My posters</h1>
            <a href="{{ route('admin.new-poster') }}" class="add-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white dark:bg-gray-800 focus:outline-none transition ease-in-out duration-150" style="color: black; font-size: 13px">
                <div>CREATE NEW POSTER</div>
            </a>
        </div>

        @if(!$posters->isEmpty())
        
        <table class="w-full mt-2">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-center">Action</th>
                </tr>

                @foreach($posters as $poster)

                <tr style="border-bottom: 1px solid #ddd">
                    <td>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="item-img" style="border: none   ">
                                <img src="{{ asset('images/posters') }}/{{ $poster -> photo }}" alt="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="w-full">
                            <p>{{ $poster -> name }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <p class="m-0">{{ $poster -> description }}</p>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.edit-poster', ['pst' => $poster -> name, 'poster' => $poster -> id]) }}" class="">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{ route('admin.del-poster', ['poster_id' => $poster -> id]) }}" class="delete-btn ml-2">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
        </table>
        
        @endif
        </div>

        <div class="tab-pane fade show" id="requests" role="tabpanel" aria-labelledby="profile-tab">

        <table class="w-full mt-2">
                <tr>
                    <th>Headline</th>
                    <th>Description</th>
                    <th class="text-center">Action</th>
                </tr>

                @foreach($slogans as $slogan)
                <tr style="border-bottom: 1px solid #ddd">
                    <td>
                        <div class="w-full">
                            <p>{{ $slogan->headline }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <p class="m-0">{{ $slogan->description }}</p>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.edit-slogan', ['slogan' => $slogan->id]) }}" class="">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
        </table>
    </div>
    </div>
</div>
</div>

</x-ht-admin-layout>