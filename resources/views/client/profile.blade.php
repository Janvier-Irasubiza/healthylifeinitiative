@section('title', 'Profile')

<x-ht-clt-layout>

    <div class="body px-4 mb-5 d-flex justify-content-center">
        <div class="col-lg-9 py-5">

        <div class="flex-section gap-5">

        <form action="{{ route('client.update-profile-pic') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="small-8 medium-2 large-2 columns img-section col-lg-2 pt-2">
            
              	<input type="hidden" name="user" value="{{ Auth::user()->id }}">
                <div class="circle border">

                <img id="output" class="profile-pic" src="{{ asset('images/profile_pictures') }}/{{ Auth::user() -> profile_picture }}">
                                
                </div>
                <div class="p-image">
                <i class="fa fa-camera upload-button"></i>
                    <input class="profile-file-input" type="file" name="profile_image" accept="image/*" onchange="loadFile(event)"/>
                </div>
            </div>
          
			<x-input-error class="mt-2" :messages="$errors->get('profile_image')" />

            <div>
            <x-primary-button class="buttons" style="border: none">
                {{ __('update') }}
            </x-primary-button>
            </div>
            </form>

            <div class="w-full">
            <section>
                <header>
                    <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Update your account's profile information.") }}
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name">Names</label>
                        
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" :value="Auth::user()->id" hidden required autocomplete="id" />
                        <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', Auth::user()->name) }}" required autocomplete="names" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                    <label for="phone">Phone number</label>
                        <input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ Auth::user()->phone }}" required autocomplete="phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div class="flex items-center gap-4">
                    <x-primary-button class="buttons" style="border: none">
                            {{ __('save changes') }}
                        </x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
            </div>

            <div class="w-full">
                    
                    <section>
                    <header>
                        <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Update Password') }}
                        </h2>
    
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Consider using a strong and random password to stay secure.') }}
                        </p>
                    </header>
    
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" :value="Auth::user()->id" hidden required autocomplete="id" />
    
                        <div>
                            <label for="">Current password</label>

                            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
    
                        <div>
                            <label for="">New password</label>
                            <input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
    
                        <div>
                            <label for="">Confirm new password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
    
                        <div class="flex items-center gap-4">
                        <x-primary-button class="buttons" style="border: none">
                                {{ __('change password') }}
                            </x-primary-button>
    
                            <small style="color: red">{{ Session::get('error') }}</small>
    
                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
    
    
                </div>
        </div>

        </div>
    </div>

</x-ht-clt-layout>