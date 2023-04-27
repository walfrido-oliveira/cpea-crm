<x-app-layout>
    <div class="py-6 create-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cadastrar Usuário') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('users.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Primeiro Nome') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" :value="old('name')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="last_name" value="{{ __('Segundo Nome') }}" />
                            <x-jet-input id="last_name" class="form-control block mt-1 w-full" type="text" name="last_name" maxlength="255" autofocus autocomplete="last-name" :value="old('last_name')" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="email" value="{{ __('E-mail') }}" required/>
                            <x-jet-input id="email" class="form-control block mt-1 w-full" type="email" name="email" required maxlength="255" autofocus autocomplete="email" :value="old('email')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="phone" value="{{ __('Telefone') }}" />
                            <x-jet-input id="phone" class="form-control block mt-1 w-full" type="tel" name="phone" maxlength="255" autofocus autocomplete="phone" :value="old('phone')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="role" value="{{ __('Nível de Acesso') }}" required/>
                            <x-custom-select :options="$roles" name="role" id="role" required :value="old('role')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="status" value="{{ __('Situação do Usuário') }}" required/>
                            <x-custom-select :options="$status" name="status" id="status" required :value="old('status')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="occupation_id" value="{{ __('Cargo') }}" required/>
                            <x-custom-select :options="$occupations" name="occupation_id" id="occupation_id" required :value="old('occupation_id')"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="department_id" value="{{ __('Departamento') }}" required/>
                            <x-custom-select :options="$departments" name="department_id" id="department_id" required :value="old('department_id')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="crq" value="{{ __('CRQ IV') }}" required/>
                            <x-jet-input id="crq" class="form-control block mt-1 w-full" type="text" name="crq" maxlength="255" required autofocus autocomplete="crq" :value="old('crq')"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <input id="signer" type="file" class="form-control @error('signer') is-invalid @enderror" name="signer" value="{{ old('signer') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
