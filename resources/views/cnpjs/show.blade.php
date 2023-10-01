<x-app-layout>
    <div class="py-6 show-cnpjs">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do CNPJ') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('cnpjs.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('cnpjs.edit', ['cnpj' => $cnpj->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-cnpj" id="cnpj_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $cnpj->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class=   "text-gray-500 font-bold">{{ $cnpj->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('CNPJ') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $cnpj->cnpj }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Razão Social') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $cnpj->corporate_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Unidade') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $cnpj->unit }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $cnpj->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $cnpj->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir departamento') }}"
             msg="{{ __('Deseja realmente apagar esse departamento?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_cnpj_modal"
             method="DELETE"
             url="{{ route('cnpjs.destroy', ['cnpj' => $cnpj->id]) }}"
             redirect-url="{{ route('cnpjs.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-cnpj').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_cnpj_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
