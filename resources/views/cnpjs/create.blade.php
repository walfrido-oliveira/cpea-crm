<x-app-layout>
    <div class="py-6 create-cnpjs">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('cnpjs.store') }}">
                @csrf
                @method("POST")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('CNPJ') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('cnpjs.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cnpj" value="{{ __('CNPJ') }}" required/>
                            <x-jet-input id="cnpj" class="form-control block mt-1 w-full" type="text" name="cnpj" maxlength="255" required autofocus autocomplete="cnpj" placeholder="{{ __('CNPJ') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="corporate_name" value="{{ __('Razão Social') }}" required/>
                            <x-jet-input id="corporate_name" class="form-control block mt-1 w-full" type="text" name="corporate_name" maxlength="255" required autofocus autocomplete="corporate_name" placeholder="{{ __('Razão Social') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="unit" value="{{ __('Unidade') }}" required/>
                            <x-jet-input id="unit" class="form-control block mt-1 w-full" type="text" name="unit" maxlength="255" required autofocus autocomplete="unit" placeholder="{{ __('Unidade') }}"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
