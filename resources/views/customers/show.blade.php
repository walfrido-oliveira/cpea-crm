<x-app-layout>
    <div class="py-6 show-customers">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Cliente') }} - {{ $customer->name }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('customers.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('customers.edit', ['customer' => $customer->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-customer" id="customer_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $customer->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg" x-data="showInfos()">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex mb-4">
                        <h2 class="w-full">Dados do Cliente</h2>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                            <button class="btn-transition-primary" type="button" id="show_all_infos" @click="isOpen() ? close() : show();">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }"
                                    class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Cód. Cliente') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome do cliente') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('CNPJ') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->formatted_cnpj }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Razão Social') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->corporate_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Setor') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->sector->name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Segmento') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->segment->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90 hidden">
                    <div class="flex flex-wrap mb-4">
                        <h2>Endereço</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('CEP') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->formatted_cep }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Endereço') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->address }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Número') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->number }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Complmento') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->complement }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Bairro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->district }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Cidade') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->city }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Estado (UF)') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->addresses[0]->state }}</p>
                        </div>
                    </div>

                </div>

                <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90 hidden">
                    <div class="flex flex-wrap mb-4">
                        <h2>Contatos Gerais</h2>
                    </div>

                    @foreach ($customer->contacts as $contact)
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-2/12">
                                <p class="font-bold">{{ $contact->generalContactType->name }}</p>
                            </div>
                            <div class="w-full md:w-1/2">
                                <p class="text-gray-500 font-bold">{{$contact->description }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90 hidden">
                    <div class="flex flex-wrap mb-4">
                        <h2>Informações Complementares</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ 'Concorrentes' }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{$customer->competitors }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ 'Observações' }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{$customer->obs }}</p>
                        </div>
                    </div>

                </div>

                <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90 hidden">
                    <div class="flex flex-wrap mb-4">
                        <h2>Informações de Cadastro</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Responsável Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->createdUser->full_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Responsável Última Atualização') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->updatedUser ? $customer->updatedUser->full_name : "-" }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $customer->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <h2>Contatos do Cliente</h2>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <h2>Empresas</h2>
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir cargo') }}"
             msg="{{ __('Deseja realmente apagar esse cargo?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_customer_modal"
             method="DELETE"
             url="{{ route('customers.destroy', ['customer' => $customer->id]) }}"
             redirect-url="{{ route('customers.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-customer').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_customer_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();

    function showInfos() {
        return {
            open: false,
            show() {
                this.open = true;
                setTimeout(() => document.getElementById("show_all_contacts").scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                }), 100);
            },
            close() {
                this.open = false;
                setTimeout(() => document.getElementById("show_all_contacts").scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                }), 100);
            },
            isOpen() {
                return this.open === true
            },
        }
    }
    </script>


</x-app-layout>
