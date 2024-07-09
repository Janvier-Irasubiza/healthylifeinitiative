@section('title', 'Sign in')

<x-guest-layout>
    <div class="mt-5">
        <div class="d-flex justify-content-center">
            <h2 style="font-size: 25px">Sign in</h2>
        </div>
        <form action="{{ route('admin.authenticate') }}" class="mt-3" method="post">
            @csrf
            <div>
                <label class="w-full" for="email">Email or Phone number</label>
                <input class="w-full mt-1" type="text" name="email" placeholder="Enter your email" autofocus>
            </div>

            <div class="mt-4">
                <label class="w-full" for="email">Password</label>
                <input class="w-full mt-1" type="password" name="password" placeholder="Enter your password">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                <button type="submit" class="buttons" style="font-weight: 500;"> SIGN IN </button>
            </div>
        </form>
    </div> 
</x-guest-layout>