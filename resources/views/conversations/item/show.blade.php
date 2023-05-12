<x-app-layout>
    <div class="py-6 show-conversation-item">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Empresa') }} - {{ $conversationItem->conversation->customer->name }} - {{ __("Conversa") }} ({{ str_pad($conversationItem->conversation->id, 5, 0, STR_PAD_LEFT) }})</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-danger" href="{{ route('customers.conversations.show', ['conversation' => $conversationItem->conversation_id]) }}">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex mb-4">
                        <h2 class="w-full">{{ __('Dados de Cadastro') }}</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Cliente') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class=   "text-gray-500 font-bold">{{ $conversationItem->conversation->customer->customer ? $conversationItem->conversation->customer->customer->name : '-'  }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('nº da Conversa') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ str_pad($conversationItem->conversation->id, 5, 0, STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('nº da Interação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->order }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Tipo de Interação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->item_type }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Responsável pela Interação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->user->full_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex mb-4">
                        <h2 class="w-full">{{ __('Dados da Interação') }}</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data/Hora da Interação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Status da Interação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                @switch($conversationItem->item_type)
                                    @case("Prospect")
                                        {{ $conversationItem->prospectingStatus ? $conversationItem->prospectingStatus->name : "-" }}
                                        @break
                                    @case("Proposta")
                                        {{ $conversationItem->proposedStatus ? $conversationItem->proposedStatus->name : "-" }}
                                        @break
                                    @case("Projeto")
                                        {{ $conversationItem->projectStatus ? $conversationItem->projectStatus->name : "-" }}
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Contato') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->detailedContact->contact }}</p>
                        </div>
                    </div>

                    @if($conversationItem->item_type == "Prospect")
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-2/12">
                                <p class="font-bold">{{ __('Aditivo') }}</p>
                            </div>
                            <div class="w-full md:w-1/2">
                                <p class="text-gray-500 font-bold">
                                    <span class="w-24 py-1 @if($conversationItem->additive) badge-success @else badge-danger @endif" >
                                        {{ $conversationItem->additive ? "Sim" : "Não" }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap">
                            <div class="w-full md:w-2/12">
                                <p class="font-bold">{{ __('IDCPEA Vinculado') }}</p>
                            </div>
                            <div class="w-full md:w-1/2">
                                <p class="text-gray-500 font-bold">{{ $conversationItem->cpea_linked_id ? $conversationItem->cpea_linked_id : '-' }}</p>
                            </div>
                        </div>
                    @endif

                    @if($conversationItem->item_type == "Prosposta")
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-2/12">
                                <p class="font-bold">{{ __('Diretoria') }}</p>
                            </div>
                            <div class="w-full md:w-1/2">
                                <p class="text-gray-500 font-bold">{{ $conversationItem->direction ? $conversationItem->direction->name : '-' }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap">
                            <div class="w-full md:w-2/12">
                                <p class="font-bold">{{ __('Gestor') }}</p>
                            </div>
                            <div class="w-full md:w-1/2">
                                <p class="text-gray-500 font-bold">{{ $conversationItem->employee ? $conversationItem->employee->full_name : '-' }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-wrap" x-data="showInfosProducts()">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Produtos') }}</p>
                        </div>
                        <div class="w-full md:w-1/2 flex">
                            <div class="w-auto mr-4">
                                @foreach ($conversationItem->products as $key => $product)
                                    <p class="text-gray-500 font-bold" @if($key > 2) x-show="isOpen()"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-90 hidden" @endif>{{ $product->name }}</p>
                                @endforeach
                            </div>
                            <div class="w-full md:w-2/12">
                                @if(count($conversationItem->products) > 3 )
                                    <button class="btn-transition-primary" type="button" id="show_all_products" @click="isOpen() ? close() : show();">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }" class="h-6 w-6 inline">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex mb-4">
                        <h2 class="w-full">{{ __('Detalhes da Conversa') }}</h2>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->item_details }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($conversationItem->item_type == "Proposta" || $conversationItem->item_type == "Projeto")
                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="mx-4 px-3 py-2 mt-4">
                        <div class="flex mb-4">
                            <h2 class="w-full">{{ __('Anexos') }}</h2>
                        </div>
                        <div class="flex flex-wrap" x-data="showInfosAttachments()">
                            <div class="w-full flex">
                                <div class="w-full">
                                    <table class="table-attachments table md:table w-full">
                                        <thead>
                                            <tr class="thead-light">
                                                <th scope="col"  class="custom-th">{{ __('Nome do Arquivo') }}</th>
                                                <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conversationItem->attachments as $key => $attachment)
                                                <tr @if($key > 3) x-show="isOpen()"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-90"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-transition:leave="transition ease-in duration-300"
                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                    x-transition:leave-end="opacity-0 transform scale-90 hidden" @endif>
                                                    <td>
                                                        <a class="text-green-600 underline font-bold" href="{{ $attachment->url }}">{{ $attachment->name }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $attachment->obs }}
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="w-full md:w-2/12">
                                    @if(count($conversationItem->attachments) > 4 )
                                        <button class="btn-transition-primary" type="button" id="show_all_products" @click="isOpen() ? close() : show();">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }" class="h-6 w-6 inline">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($conversationItem->item_type == "Proposta")
                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="mx-4 px-3 py-2 mt-4">
                        <div class="flex mb-4">
                            <h2 class="w-full">{{ __('Valores') }}</h2>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full flex">
                                <div class="w-full">
                                    <table class="table-values table md:table w-full">
                                        <thead>
                                            <tr class="thead-light">
                                                <th scope="col"  class="custom-th" style="white-space: nowrap;">{{ __('Tipo de valor') }}</th>
                                                <th scope="col"  class="custom-th" style="white-space: nowrap;">{{ __('Descrição do valor') }}</th>
                                                <th scope="col"  class="custom-th" style="white-space: nowrap;">{{ __('Valor') }}</th>
                                                <th scope="col"  class="custom-th" style="white-space: nowrap;">{{ __('Observações') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conversationItem->values as $key => $value)
                                                <tr @if($key > 3) x-show="isOpen()"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-90"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-transition:leave="transition ease-in duration-300"
                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                    x-transition:leave-end="opacity-0 transform scale-90 hidden" @endif>
                                                    <td>
                                                        {{ __($value->value_type) }}
                                                    </td>
                                                    <td>
                                                        {{ $value->description }}
                                                    </td>
                                                    <td style="white-space: nowrap;">
                                                        R$ {{ number_format($value->value, 2, ",", ".") }}
                                                    </td>
                                                    <td>
                                                        {{ $value->obs }}
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="w-full md:w-2/12">
                                    @if(count($conversationItem->values) > 4 )
                                        <button class="btn-transition-primary" type="button" id="show_all_products" @click="isOpen() ? close() : show();">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }" class="h-6 w-6 inline">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="py-2 my-2 bg-white rounded-lg">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex mb-4">
                        <h2 class="w-full">{{ __('Reunião/Notificação') }}</h2>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Tipo de Agenda') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->schedule_type ? $conversationItem->schedule_type : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome da Agenda') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->schedule_name ? $conversationItem->schedule_name : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data/Hora da Reunião') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->schedule_at ? $conversationItem->schedule_at->format('d/m/Y H:i:s') : "-" }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Organizador') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->organizer ? $conversationItem->organizer->full_name : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Destinatários') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->addresses ? $conversationItem->addresses : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Destinatários Opcionais') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->optional_addressees ? $conversationItem->optional_addressees : "-" }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Detalhes do Agendamento') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $conversationItem->schedule_details ? $conversationItem->schedule_details : '-' }}</p>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>
        function showInfosProducts() {
            return {
                open: false,
                show() {
                    this.open = true;
                },
                close() {
                    this.open = false;
                },
                isOpen() {
                    return this.open === true
                },
            }
        }

        function showInfosAttachments() {
            return {
                open: false,
                show() {
                    this.open = true;
                },
                close() {
                    this.open = false;
                },
                isOpen() {
                    return this.open === true
                },
            }
        }

        function showInfosValues() {
            return {
                open: false,
                show() {
                    this.open = true;
                },
                close() {
                    this.open = false;
                },
                isOpen() {
                    return this.open === true
                },
            }
        }

    </script>

</x-app-layout>
