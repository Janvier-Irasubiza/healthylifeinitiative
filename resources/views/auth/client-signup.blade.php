@section('title', 'Create account')

<x-guest-layout>
    <div class="mt-5 mb-3">
        <div class="d-flex justify-content-center">
            <h2 style="font-size: 25px">Create account</h2>
        </div>
        <form action="{{ route('account.create') }}" class="mt-3" method="POST">        
            @csrf

            <div>
                <label class="w-full" for="name">Names</label>
                <input class="w-full mt-1" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" autofocus>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label class="w-full mt-4" for="email">Email</label>
                <input class="w-full mt-1" type="text" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label class="mt-4 w-full" for="email">Phone number</label>
                <input class="w-full mt-1" type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="w-full" for="password">Password</label>
                <input class="w-full mt-1" type="password" name="password" placeholder="Type your password here">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="w-full" for="email">Confirm Password</label>
                <input class="w-full mt-1" type="password" name="password_confirmation" placeholder="Confirm your password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                <div>
                Already have an account?  <a class="underline text-sm text-gray-600 dark:text-gray-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('client-login') }}">
                    {{ __('Sign in') }}
                </a>
                </div>
                <div>
                    <button type="submit" class="p-btns" style="font-weight: 500;"> SIGN UP </button>
                </div>
            </div>
        </form>
    </div> 
</x-guest-layout>