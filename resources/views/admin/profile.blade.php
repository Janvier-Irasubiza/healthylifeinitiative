@section('title', 'Profile')

<x-ht-admin-layout>

    <div class="body px-4 mb-5 py-5 d-flex justify-content-center">
        <div class="col-lg-9 py-3">

        <div class="flex-section gap-5">
            <div class="w-full mb-5">
            <section>
                <header>
                    <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Update your account's profile information.") }}
                    </p>
                </header>

                <form method="post" action="{{ route('admin.profile-update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name">Names</label>
                        
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" :value="Auth::guard('admin')->user()->id" hidden required autocomplete="id" />
                        <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', Auth::guard('admin')->user()->name) }}" required autocomplete="names" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', Auth::guard('admin')->user()->email) }}" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                    <label for="phone">Phone number</label>
                        <input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', Auth::guard('admin')->user()->phone) }}" required autocomplete="phone" />
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
    
                    <form method="post" action="{{ route('admin.password-update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <x-text-input id="id" name="id" type="hidden" class="mt-1 block w-full" :value="Auth::guard('admin')->user()->id" required autocomplete="id" />
    
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

</x-ht-admin-layout>