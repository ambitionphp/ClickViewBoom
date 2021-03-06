<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <div class="text-center">
                <x-jet-authentication-card-logo />
                <h3 class="font-semibold text-xl">
                    {{ config('app.name') }}
                </h3>
            </div>
        </x-slot>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h3 class="font-semibold text-lg">
                Log into your account
            </h3>

            <div class="mt-4">
                <x-jet-label for="email" class="{{ $errors->has('email') ? 'text-red-600' : '' }}" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-600' : '' }}" type="email" name="email" :value="old('email')" required autofocus />
                @if($errors->has('email'))
                    <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="mt-4">
                <x-jet-label for="password" class="{{ $errors->has('password') ? 'text-red-600' : '' }}" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full {{ $errors->has('password') ? 'border-red-600' : '' }}" type="password" name="password" required autocomplete="current-password" />
                @if($errors->has('password'))
                    <span class="text-red-600 text-xs">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
