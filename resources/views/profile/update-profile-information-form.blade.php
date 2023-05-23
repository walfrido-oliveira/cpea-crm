<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informações do Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Atualize as informações de perfil e endereço de e-mail da sua conta.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Imagem') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Selecionar uma nova imagem') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remover foto') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="name" value="{{ __('Nome') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full form-control" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Sobrenome -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="last_name" value="{{ __('Sobrenome') }}" />
            <x-jet-input id="last_name" type="text" class="mt-1 block w-full form-control" wire:model.defer="state.last_name" autocomplete="last_name" />
            <x-jet-input-error for="last_name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full form-control" wire:model.defer="state.email" readonly/>
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="phone" value="{{ __('Telefone') }}" />
            <x-jet-input id="phone" type="tel" class="mt-1 block w-full form-control" wire:model.defer="state.phone" />
            <x-jet-input-error for="phone" class="mt-2" />
         </div>

         <!-- Nível de Acesso -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="role" value="{{ __('Nível de Acesso') }}" />
            <x-jet-input id="role" type="text" class="mt-1 block w-full form-control" wire:model.defer="state.role" readonly/>
            <x-jet-input-error for="role" class="mt-2" />
        </div>

        <!-- Situação -->
        <div class="col-span-8 sm:col-span-6">
            <x-jet-label for="status" value="{{ __('Situação do Usuário') }}" />
            <x-jet-input id="status" type="text" class="mt-1 block w-full form-control" wire:model.defer="state.status" readonly/>
            <x-jet-input-error for="status" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Salvo.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
