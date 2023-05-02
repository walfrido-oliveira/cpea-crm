<x-app-layout>
    <div class="py-6 create-detailed-contact">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.detailed-contacts.store') }}">
                @csrf
                @method("POST")
                <input type="hidden" name="customer_id" value="{{ app('request')->get("customer") }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Novo Contato do Cliente') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('customers.show', ['customer' => app('request')->get("customer")]) }}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Dados Cadastrais</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="contact" value="{{ __('Nome do Contato') }}" required/>
                            <x-jet-input id="contact" class="form-control block mt-1 w-full" type="text" name="contact" maxlength="255" required autofocus autocomplete="contact" value="{{ old('contact') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="mail" value="{{ __('Email') }}"/>
                            <x-jet-input id="mail" class="form-control block mt-1 w-full" type="email" name="mail" maxlength="255" autofocus autocomplete="mail" value="{{ old('mail') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="phone" value="{{ __('Telefone') }}"/>
                            <x-jet-input id="phone" class="form-control block mt-1 w-full" type="tel" name="phone" maxlength="255" autofocus autocomplete="phone" value="{{ old('phone') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cell_phone" value="{{ __('Celular') }}"/>
                            <x-jet-input id="cell_phone" class="form-control block mt-1 w-full" type="tel" name="cell_phone" maxlength="255" autofocus autocomplete="cell_phone" value="{{ old('cell_phone') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="role" value="{{ __('Cargo') }}"/>
                            <x-jet-input id="role" class="form-control block mt-1 w-full" type="text" name="role" maxlength="255" autofocus autocomplete="role" value="{{ old('role') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="linkedin" value="{{ __('Linkedin') }}"/>
                            <x-jet-input id="linkedin" class="form-control block mt-1 w-full" type="text" name="linkedin" maxlength="255" autofocus autocomplete="linkedin" value="{{ old('linkedin') }}"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Secretária</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="secretary" value="{{ __('Nome') }}"/>
                            <x-jet-input id="secretary" class="form-control block mt-1 w-full" type="text" name="secretary" maxlength="255" autofocus autocomplete="secretary" value="{{ old('secretary') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="mail_secretary" value="{{ __('Email') }}"/>
                            <x-jet-input id="mail_secretary" class="form-control block mt-1 w-full" type="email" name="mail_secretary" maxlength="255" autofocus autocomplete="mail_secretary" value="{{ old('mail_secretary') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="phone_secretary" value="{{ __('Telefone') }}"/>
                            <x-jet-input id="phone_secretary" class="form-control block mt-1 w-full" type="tel" name="phone_secretary" maxlength="255" autofocus autocomplete="phone_secretary" value="{{ old('phone_secretary') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cell_phone_secretary" value="{{ __('Celular') }}"/>
                            <x-jet-input id="cell_phone_secretary" class="form-control block mt-1 w-full" type="tel" name="cell_phone_secretary" maxlength="255" autofocus autocomplete="cell_phone_secretary" value="{{ old('cell_phone_secretary') }}"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="obs" value="{{ __('Observações') }}"/>
                            <textarea name="obs" id="obs" cols="30" rows="5" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control block mt-1 w-full">{{ old('obs') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
