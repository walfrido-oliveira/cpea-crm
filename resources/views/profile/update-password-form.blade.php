<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Atualizar senha') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Certifique-se de que sua conta está usando uma senha longa e aleatória para permanecer segura.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('Senha Atual') }}" />
            <div class="mt-1" x-data="{ show: true }"   >
                <div class="relative">
                  <input wire:model.defer="state.current_password" :type="show ? 'password' : 'text'" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" id="current_password" name="current_password" required autocomplete="current-password">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 576 512">
                      <path fill="currentColor"
                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                      </path>
                    </svg>

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 640 512">
                      <path fill="currentColor"
                        d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                      </path>
                    </svg>

                  </div>
                </div>
            </div>

            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('Nova Senha') }}" />
            <div class="mt-1" x-data="{ show: true }"   >
                <div class="relative">
                  <input wire:model.defer="state.password" :type="show ? 'password' : 'text'" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" id="password" name="password" required autocomplete="current-password">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 576 512">
                      <path fill="currentColor"
                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                      </path>
                    </svg>

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 640 512">
                      <path fill="currentColor"
                        d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                      </path>
                    </svg>

                  </div>
                </div>
            </div>
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('Confirmar Senhar') }}" />
            <div class="mt-1" x-data="{ show: true }"   >
                <div class="relative">
                  <input wire:model.defer="state.password_confirmation" :type="show ? 'password' : 'text'" class="form-input rounded-md shadow-sm form-control block mt-1 w-full" name="password_confirmation" id="password_confirmation" required wire:model.defer="state.password_confirmation" autocomplete="new-password">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 576 512">
                      <path fill="currentColor"
                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                      </path>
                    </svg>

                    <svg class="h-5 text-gray-500" fill="none" @click="show = !show"
                      :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg"
                      viewbox="0 0 640 512">
                      <path fill="currentColor"
                        d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                      </path>
                    </svg>

                  </div>
                </div>
            </div>
            <x-jet-input-error for="password_confirmation" class="mt-2" />
            <div id="password-validation">
                <ul>
                    <li id="letter" class="invalid-password-role">{{ __('A lowercase letter') }}</li>
                    <li id="capital" class="invalid-password-role">{{ __('A uppercase letter') }}</li>
                    <li id="number" class="invalid-password-role">{{ __('A number') }}</li>
                    <li id="special" class="invalid-password-role">{{ __('A special chacters') }}</li>
                    <li id="length" class="invalid-password-role">{{ __('Minimum 8 characters') }}</li>
                    <li id="confirmation" class="invalid-password-role">{{ __('Password Confirmation') }}</li>
                </ul>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Salvo.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
