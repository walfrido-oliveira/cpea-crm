<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <input id="email" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" type="text" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Usuário') }}"/>
            </div>

            <x-password/>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Mantenha-me conectado') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-jet-button class="w-full">
                    {{ __('ENTRAR') }}
                </x-jet-button>
            </div>

            <div class="flex items-center justify-center">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-jet-authentication-card>

</x-guest-layout>
