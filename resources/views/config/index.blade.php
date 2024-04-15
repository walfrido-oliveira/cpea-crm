<x-app-layout>
    <div class="py-6 edit-config">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('config.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Configurações') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('config.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Tempo de Sessão')" for="session_lifetime" required/>
                            <x-jet-input id="session_lifetime" class="form-control block w-full" type="text" name="session_lifetime" maxlength="255" :value="$sessionLifeTime" required autofocus autocomplete="session_lifetime" placeholder="{{ __('Valor em minutos') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Quantidade de Meses (Nova Cliente)')" for="new_customer_months" required/>
                            <x-jet-input id="new_customer_months" class="form-control block w-full" type="text" name="new_customer_months" maxlength="255" :value="$newCustomerMonths" required autofocus autocomplete="new_customer_months" placeholder="{{ __('Valor em meses') }}"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>

