<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col items-end mt-4 space-y-2">
                <!-- Glavno login dugme -->
                <x-button>
                    {{ __('Log in') }}
                </x-button>

                <!-- Forgot password link -->
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 mt-2" href="{{ route('password.request') }}">
                        {{ __('Zaboravili ste lozinku?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-700 mt-2">
                        {{ __("Nemaš nalog? Registruj se") }}
                    </a>
                @endif
                
                <a href="{{ route('admin.login') }}" class="text-sm text-gray-500 hover:text-gray-700 mt-2">
                    {{ __('Prijavi se kao admin') }}
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
