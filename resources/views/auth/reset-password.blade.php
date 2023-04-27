<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <h1>{{ __('Redefinir Senha') }}</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mt-4">
                <x-jet-input id="email" class="form-control block mt-1 w-full" type="hidden" name="email" :value="old('email', $request->email)" required readonly autofocus />
            </div>

            <div class="mt-4">
                <input id="password" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" type="password" minlength="8" maxlength="16" name="password"
                required autocomplete="new-password" placeholder="{{ __('Senha') }}" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"/>
            </div>

            <div class="mt-4">
                <input id="password_confirmation" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="{{ __('Confirmar Senha') }}"/>
                <x-password-validation />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-jet-button class="w-full">
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
