<x-app-layout>
    <div class="py-6 show-proposed-statuss">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Empresa') }} - {{ $conversation->customer->name }} - {{ __("Conversa") }} ({{ str_pad($conversation->id, 5, 0, STR_PAD_LEFT) }})</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-danger" href="{{ route('customers.show', ['customer' => $conversation->customer_id]) }}">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </div>
            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="flex mx-4 px-3 py-2 mt-4">
                    <h2 class="w-full px-3 mb-6 md:mb-0">Interações</h2>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                        <a class="btn-outline-info" href="{{ route('customers.conversations.item.create', ['conversation' => $conversation->id ]) }}" id="add_conversation">
                            Nova interação
                        </a>
                    </div>
                </div>
                <div class="flex py-2 mt-4">
                    <table class="table-items table table-responsive md:table w-full">
                        <thead>
                            <tr class="thead-light">
                                <th scope="col"  class="custom-th">{{ __('#') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Tipo de Interação') }}</th>
                                <th scope="col"  class="custom-th">{{ __('IDCPEA') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Data da Interação') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Responsável') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Detalhes') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Contato') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Status da Interação') }}</th>
                                <th scope="col"  class="custom-th">{{ __('Valor da Proposta') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($conversation->items as $key => $item)
                            <tr>
                                <td>
                                    <a class="text-green-600 underline font-bold" href="{{ route("customers.conversations.item.show", ["item" => $item->id]) }}">
                                        {{ $key + 1 }}
                                    </a>
                                </td>
                                <td>{{ $item->item_type }}</td>
                                <td>
                                    @if($item->item_type == "Proposta")
                                        {{ $item->conversation->cpea_id ? $item->conversation->cpea_id : '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->user->full_name }}</td>
                                <td>{{ $item->item_details }}</td>
                                <td>{{ $item->detailedContact->contact }}</td>
                                <td>
                                    @switch($item->item_type)
                                        @case("Prospect")
                                            {{ $item->prospectingStatus ? $item->prospectingStatus->name : "-" }}
                                            @break
                                        @case("Proposta")
                                            {{ $item->proposedStatus ? $item->proposedStatus->name : "-" }}
                                            @break
                                        @case("Projeto")
                                            {{ $item->projectStatus ? $item->projectStatus->name : "-" }}
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($item->item_type == "Proposta")
                                       R$ {{ number_format($item->totalValues(), 2, ",", ".") }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
