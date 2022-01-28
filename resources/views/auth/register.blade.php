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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h3 class="font-semibold text-lg">
                Create a free account
            </h3>

            <div class="mt-4">
                <x-jet-label for="email" class="{{ $errors->has('email') ? 'text-red-600' : '' }}" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-600' : '' }}" type="email" name="email" :value="old('email')" required />
                @if($errors->has('email'))
                    <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="mt-4">
                <x-jet-label for="password" class="{{ $errors->has('password') ? 'text-red-600' : '' }}" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full {{ $errors->has('password') ? 'border-red-600' : '' }}" type="password" name="password" required autocomplete="new-password" />
                @if($errors->has('password'))
                    <span class="text-red-600 text-xs">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" class="{{ $errors->has('terms') ? 'border-red-600' : '' }}" id="terms"/>

                            <div class="ml-2 {{ $errors->has('terms') ? 'text-red-600' : '' }}">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
