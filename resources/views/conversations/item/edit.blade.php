<x-app-layout>
    <div class="py-6 create-contact-type">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.conversations.item.update', ['']) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <input type="hidden" name="conversation_item_id" id="conversation_item_id" value="{{ $conversationItem->id }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar interação') }} - {{ $conversation->customer->name }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('customers.conversations.show', ['conversation' =>  $conversation->id]) }}"
                                class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Tipo de Interação</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-1 py-1 mt-0 custom-radio ml-3">
                        <div class="bg-gray-200 radios-container">
                            @switch($conversationItem->item_type)
                                @case("Prospect")
                                    <div class="inline-flex inner-item p-2">
                                        <input type="radio" name="item_type" id="prospect" checked hidden value="Prospect"/>
                                        <label for="prospect" class="radio">Prospect</label>
                                    </div>
                                    @break
                                @case("Proposta")
                                    <div class="inline-flex inner-item p-2">
                                        <input type="radio" name="item_type" id="proposta" checked hidden value="Proposta"/>
                                        <label for="proposta" class="radio">Proposta</label>
                                    </div>
                                    @break

                                @case("Projeto")
                                    <div class="inline-flex inner-item p-2">
                                        <input type="radio" name="item_type" id="projeto" checked hidden value="Projeto"/>
                                        <label for="projeto" class="radio">Projeto</label>
                                    </div>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Dados de Integração</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="interaction_at" value="{{ __('Data/Hora da Interação') }}" required/>
                            <x-jet-input id="interaction_at" class="form-control block mt-1 w-full" type="datetime-local" name="interaction_at" required autofocus value="{{ old('interaction_at') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 Prospect-status status">
                            <x-jet-label for="prospecting_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$prospectingStatuses" value="{{ old('prospecting_status_id') }}" name="prospecting_status_id" id="prospecting_status_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 hidden Proposta-status status">
                            <x-jet-label for="proposed_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$proposedsStatuses" value="{{ old('proposed_status_id') }}" name="proposed_status_id" id="proposed_status_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 hidden Projeto-status status">
                            <x-jet-label for="project_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$projectStatus" value="{{ old('project_status_id') }}" name="project_status_id" id="project_status_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="detailed_contact_id" value="{{ __('Contato') }}" required/>
                            <x-custom-select :options="$detailedContacts" value="{{ old('detailed_contact_id') }}" name="detailed_contact_id" id="detailed_contact_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="products" value="{{ __('Produtos') }}" required/>
                            <x-custom-multi-select multiple :options="$products" name="products[]" id="products" :value="[]" select-class="form-input" class="" no-filter="no-filter"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields hidden">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="direction_id" value="{{ __('Diretoria') }}" required/>
                            <x-custom-select :options="$directions" value="{{ old('direction_id') }}" name="direction_id" id="direction_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="employee_id" value="{{ __('Gestor') }}" required/>
                            <x-custom-select :options="[]" value="{{ old('employee_id') }}" name="employee_id" id="employee_id" class="mt-1"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Detalhes da Conversa</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <textarea name="item_details" id="item_details" cols="30" rows="5" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control block mt-1 w-full">{{ old('item_details') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg proposed-fields @if($conversationItem->item_type != "Proposta")hidden @endif">
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <h2 class="w-full px-3 mb-6 md:mb-0">Anexos</h2>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                                <button class="btn-outline-info" type="button"  id="add_attachment">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-2 table-responsive">
                        <table class="table-attachments table md:table w-full">
                            <thead>
                                <tr class="thead-light">
                                    <th scope="col"  class="custom-th">{{ __('Nome do Arquivo') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conversationItem->attachments as $attachment)
                                    @include('conversations.item.attachment-content', ['attachment' => $attachment])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg proposed-fields @if($conversationItem->item_type != "Proposta")hidden @endif">
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <h2 class="w-full px-3 mb-6 md:mb-0">Valores</h2>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                                <button class="btn-outline-info" type="button"  id="add_value">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg" x-data="showFieldsSchedule()">
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <h2 class="w-full px-3 mb-6 md:mb-0">Agendar Reunião/Notificação</h2>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                            <button class="btn-transition-primary" type="button" id="show_all_infos" @click="isOpen() ? close() : show();">
                                <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="w-full" x-show="isOpen()"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90 hidden">
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_type" value="{{ __('Tipo de Agenda') }}"/>
                                <x-custom-select :options="array('internal' => 'Reunião Interna', 'external' => 'Reunião Externa')" value="{{ old('schedule_type') }}" name="schedule_type" id="schedule_type" class="mt-1"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_name" value="{{ __('Nome da Agenda') }}"/>
                                <x-jet-input id="schedule_name" class="form-control block mt-1 w-full" type="text" name="schedule_name" maxlength="255" autofocus autocomplete="schedule_name" value="{{ old('schedule_name') }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_at" value="{{ __('Data/Hora da Reunião') }}"/>
                                <x-jet-input id="schedule_at" class="form-control block mt-1 w-full" type="datetime-local" name="schedule_at" autofocus value="{{ old('schedule_at') }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="organizer_id" value="{{ __('Organizador') }}"/>
                                <x-custom-select :options="$organizers" value="{{ old('organizer_id') }}" name="organizer_id" id="organizer_id" class="mt-1"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="addressees" value="{{ __('Destinatários') }}"/>
                                <x-jet-input id="addressees" class="form-control block mt-1 w-full" type="text" name="addressees" maxlength="255" autofocus autocomplete="addressees" value="{{ old('addressees') }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="optional_addressees" value="{{ __('Destinatários Opcionais') }}"/>
                                <x-jet-input id="optional_addressees" class="form-control block mt-1 w-full" type="text" name="optional_addressees" maxlength="255" autofocus autocomplete="optional_addressees" value="{{ old('optional_addressees') }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_details" value="{{ __('Detalhes do Agendamento') }}"/>
                                <textarea name="schedule_details" id="schedule_details" cols="30" rows="5" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control block mt-1 w-full">{{ old('schedule_details') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-modal title="{{ __('Excluir Anexo') }}"
            msg="{{ __('Deseja realmente apagar esse anexo?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_attachment_modal"
            confirm_id="confirm_attachment_delete" cancel_modal="cancel_attachment_delete"
            method="DELETE"
            redirect-url="{{ route('customers.conversations.item.edit', ['item' => $conversationItem->id]) }}"/>

    @include("conversations.item.attachment-modal")
    @include('conversations.item.scripts')
</x-app-layout>
