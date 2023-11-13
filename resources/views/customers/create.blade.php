<x-app-layout>
    <div class="py-6 create-products">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                @method("POST")
                <input type="hidden" name="customer_id" id="customer_id" value="{{ app('request')->get('customer') }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Novo') . (app('request')->get('customer') ? " Empresa" : " Cliente") }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('customers.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Dados {{ (app('request')->get('customer') ? " da Empresa" : " do Cliente") }}</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome do Cliente') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" value="{{ old('name') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cnpj" value="{{ __('CNPJ') }}" />
                            <x-jet-input id="cnpj" class="form-control block mt-1 w-full" type="text" name="cnpj" maxlength="18" autofocus autocomplete="cnpj" value="{{ old('cnpj') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="corporate_name" value="{{ __('Razão Social') }}" required/>
                            <x-jet-input id="corporate_name" class="form-control block mt-1 w-full" type="text" name="corporate_name" maxlength="255" required autofocus autocomplete="corporate_name" value="{{ old('corporate_name') }}"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="segment_id" value="{{ __('Segmento') }}" required/>
                            <x-custom-select :options="$segments" value="" name="segment_id" id="segment_id" class="mt-1" value="{{ old('segment_id') }}"/>
                        </div>
                    </div>
                </div>
                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Endereço</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="cep" value="{{ __('CEP') }}" />
                            <x-jet-input id="cep" class="form-control block mt-1 w-full" type="text" name="addresses[0][cep]" maxlength="9"  autofocus autocomplete="cep" value="{{ old('addresses.0.cep') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="address" value="{{ __('Endereço') }}" />
                            <x-jet-input id="address" class="form-control block mt-1 w-full" type="text" name="addresses[0][address]" maxlength="255"  autofocus autocomplete="address" value="{{ old('addresses.0.address') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="number" value="{{ __('Número') }}" />
                            <x-jet-input id="number" class="form-control block mt-1 w-full" type="text" name="addresses[0][number]" maxlength="255"  autofocus autocomplete="number" value="{{ old('addresses.0.number') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="complement" value="{{ __('Complemento') }}"/>
                            <x-jet-input id="complement" class="form-control block mt-1 w-full" type="text" name="addresses[0][complement]" maxlength="255" autofocus autocomplete="complement" value="{{ old('addresses.0.complement') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="district" value="{{ __('Bairro') }}" />
                            <x-jet-input id="district" class="form-control block mt-1 w-full" type="text" name="addresses[0][district]" maxlength="255"  autofocus autocomplete="district" value="{{ old('addresses.0.district') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="city" value="{{ __('Cidade') }}" />
                            <x-jet-input id="city" class="form-control block mt-1 w-full" type="text" name="addresses[0][city]" maxlength="255"  autofocus autocomplete="city" value="{{ old('addresses.0.city') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="state" value="{{ __('Estado (UF)') }}" />
                            <x-custom-select :options="states()" value="{{ old('addresses.0.state') }}" name="addresses[0][state]" id="state" class="mt-1"/>
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
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="competitors" value="{{ __('Concorrentes') }}"/>
                            <x-jet-input id="competitors" class="form-control block mt-1 w-full" type="text" name="competitors" maxlength="255" autofocus autocomplete="competitors" value="{{ old('competitors') }}"/>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

    @include('customers.scripts')
</x-app-layout>
