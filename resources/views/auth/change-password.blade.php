<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <h1>{{ __('Cadastrar Senha') }}</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="new_user" value="{{ $new_user }}">

            <div class="mt-4">
                <x-jet-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email', $email)" readonly required autofocus />
            </div>

            <div class="mt-4">
                <input id="password" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" type="password" minlength="8" maxlength="16" name="password"
                required autocomplete="new-password" placeholder="{{ __('Password') }}" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"/>
            </div>

            <div class="mt-4">
                <input id="password_confirmation" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="{{ __('Password Confirmation') }}"/>
                <x-password-validation />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Salvar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>

</x-guest-layout>
