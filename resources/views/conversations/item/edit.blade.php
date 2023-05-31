@include('conversations.item.styles')

<x-app-layout>
    <div class="py-6 create-contact-type">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.conversations.item.update', [$conversationItem->id]) }}" enctype="multipart/form-data">
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
                            <div class="inline-flex inner-item p-2">
                                <input type="radio" name="item_type" id="prospect" @if($conversationItem->item_type == "Prospect") checked @endif hidden value="Prospect" />
                                <label for="prospect" class="radio" style="@if($checkproject) cursor: not-allowed; @endif">Prospect</label>
                            </div>
                            <div class="inline-flex inner-item p-2">
                                <input type="radio" name="item_type" id="proposta" hidden value="Proposta" @if($conversationItem->item_type == "Proposta") checked @endif />
                                <label for="proposta" class="radio" style="@if(!$checkprospect || $checkproject) cursor: not-allowed; @endif">Proposta</label>
                            </div>
                            <div class="inline-flex inner-item p-2">
                                <input type="radio" name="item_type" id="projeto" hidden value="Projeto" @if($conversationItem->item_type == "Projeto") checked @endif />
                                <label for="projeto" class="radio" style="@if(!$checkproposed) cursor: not-allowed; @endif">Projeto</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Dados da Interação</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="interaction_at" value="{{ __('Data/Hora da Interação') }}" required/>
                            <x-jet-input id="interaction_at" class="form-control block mt-1 w-full" type="datetime-local" name="interaction_at" autofocus value="{{ $conversationItem->interaction_at }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 Prospect-status status @if($conversationItem->item_type != "Prospect") hidden @endif">
                            <x-jet-label for="prospecting_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$prospectingStatuses" value="{{ $conversationItem->prospecting_status_id }}" name="prospecting_status_id" id="prospecting_status_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 Proposta-status status @if($conversationItem->item_type != "Proposta") hidden @endif">
                            <x-jet-label for="proposed_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$proposedsStatuses" value="{{ $conversationItem->proposed_status_id }}" name="proposed_status_id" id="proposed_status_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 Projeto-status status @if($conversationItem->item_type != "Projeto") hidden @endif">
                            <x-jet-label for="project_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$projectStatus" value="{{ $conversationItem->project_status_id }}" name="project_status_id" id="project_status_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="detailed_contact_id" value="{{ __('Contato') }}" required/>
                            <x-custom-select :options="$detailedContacts" value="{{ $conversationItem->detailed_contact_id }}" required name="detailed_contact_id" id="detailed_contact_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="products" value="{{ __('Produtos') }}" required/>
                            <x-custom-multi-select multiple :options="$products" name="products[]" id="products" :value="$conversationItemProduts" select-class="form-input" class="" no-filter="no-filter"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 prospects-fields">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="additive" value="{{ __('Aditivo') }}" required/>
                            <x-custom-select :options="array('y' => 'Sim', 'n' => 'Não')" value="{{ $conversationItem->additive ? 'y' : 'n' }}" name="additive" id="additive" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cpea_linked_id" value="{{ __('IDCPEA Vinculado') }}"/>
                            <x-custom-select :options="$cpeaIds" value="{{ $conversationItem->cpea_linked_id }}" name="cpea_linked_id" id="cpea_linked_id" select-class="no-nice-select no-hide" class="mt-1 no-nice-select" disabled/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields hidden">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="direction_id" value="{{ __('Diretoria') }}" required/>
                            <x-custom-select :options="$directions" value="{{ $conversationItem->direction_id }}" name="direction_id" id="direction_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="department_id" value="{{ __('Departamento') }}" required/>
                            <x-custom-select :options="$departments" name="department_id" id="department_id" class="mt-1" value=""/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="employee_id" value="{{ __('Gestor') }}" required/>
                            <x-custom-select :options="[]" value="{{ $conversationItem->employee_id }}" name="employee_id" id="employee_id" class="mt-1"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Detalhes da Conversa</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <textarea name="item_details" id="item_details" cols="30" rows="5" class="ckeditor" required>{{ $conversationItem->item_details }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg proposed-fields prospects-fields">
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
                    <div class="flex mx-4 px-3 py-2 mt-4">
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

                <div class="py-2 my-2 bg-white rounded-lg proposed-fields prospects-fields">
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
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <table class="table-values table md:table w-full">
                            <thead>
                                <tr class="thead-light">
                                    <th scope="col"  class="custom-th">{{ __('Tipo de valor') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Descrição do valor') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Valor') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
                                    <th scope="col"  class="custom-th">{{ __('') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conversationItem->values as $value)
                                    @include('conversations.item.value-content', ['value' => $value])
                                @endforeach
                            </tbody>
                        </table>
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
                                <x-custom-select :options="array('internal' => 'Follow up', 'external' => 'Reunião Externa')" value="{{ $conversationItem->schedule_type }}" name="schedule_type" id="schedule_type" class="mt-1"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_name" value="{{ __('Nome da Agenda') }}"/>
                                <x-jet-input id="schedule_name" class="form-control block mt-1 w-full" type="text" name="schedule_name" maxlength="255" autofocus autocomplete="schedule_name" value="{{ $conversationItem->schedule_name }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="meeting_form" value="{{ __('Forma de Reunião') }}"/>
                                <x-custom-select :options="array('online' => 'Online', 'presential' => 'Presencial')" value="{{ $conversationItem->meeting_form ? $conversationItem->meeting_form : 'online' }}" name="meeting_form" id="meeting_form" class="mt-1"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 @if($conversationItem->meeting_form == 'online' || !$conversationItem->meeting_form) hidden @endif meeting-place">
                                <x-jet-label for="meeting_place" value="{{ __('Local') }}"/>
                                <x-jet-input id="meeting_place" class="form-control block mt-1 w-full" type="text" name="meeting_place" maxlength="255" autofocus autocomplete="meeting_place" value="{{ $conversationItem->meeting_place }}"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 @if($conversationItem->meeting_form == 'presential') hidden @endif teams-url">
                                <x-jet-label for="teams_url" value="{{ __('Link do Teams') }}"/>
                                <x-jet-input id="teams_url" class="form-control block mt-1 w-full" type="text" name="teams_url" maxlength="255" autofocus autocomplete="teams_url" value="{{ $conversationItem->teams_url }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_at" value="{{ __('Data/Hora da Reunião') }}"/>
                                <x-jet-input id="schedule_at" class="form-control block mt-1 w-full" type="datetime-local" name="schedule_at" autofocus value="{{ $conversationItem->schedule_at }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="organizer_id" value="{{ __('Organizador') }}"/>
                                <x-custom-select :options="$organizers" value="{{ $conversationItem->organizer_id }}" name="organizer_id" id="organizer_id" class="mt-1"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <div class="flex py-2 mt-4">
                                    <h2 class="w-full mb-6 md:mb-0">Destinatários</h2>
                                    <div class="w-full md:w-1/2 mb-6 md:mb-0 flex justify-end align-baseline">
                                        <div class="w-full md:w-1/2 mb-6 md:mb-0 flex justify-end align-baseline">
                                            <button class="btn-outline-info" type="button"  id="add_address">
                                                Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex py-2">
                                    <table class="table-address table md:table w-full">
                                        <thead>
                                            <tr class="thead-light">
                                                <th scope="col"  class="custom-th">{{ __('Nome') }}</th>
                                                <th scope="col"  class="custom-th">{{ __('Email') }}</th>
                                                <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
                                                <th scope="col"  class="custom-th">{{ __('') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conversationItem->addresses as $address)
                                                @include('conversations.item.address-content', ['address' => $address])
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_details" value="{{ __('Detalhes do Agendamento') }}"/>
                                <textarea name="schedule_details" id="schedule_details" cols="30" rows="5" class="ckeditor">{{ $conversationItem->schedule_details }}</textarea>
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

    <x-modal title="{{ __('Excluir Valor') }}"
            msg="{{ __('Deseja realmente apagar esse valor?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_value_modal"
            confirm_id="confirm_value_delete" cancel_modal="cancel_value_delete"
            method="DELETE"
            redirect-url="{{ route('customers.conversations.item.edit', ['item' => $conversationItem->id]) }}"/>

    <x-modal title="{{ __('Excluir Destinatário') }}"
            msg="{{ __('Deseja realmente apagar esse destinatário?') }}"
            confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_address_modal"
            confirm_id="confirm_address_delete" cancel_modal="cancel_address_delete"
            method="DELETE"
            redirect-url="{{ route('customers.conversations.item.edit', ['item' => $conversationItem->id]) }}"/>

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    @include("conversations.item.attachment-modal", ['type' => 'edit'])
    @include("conversations.item.value-modal", ['type' => 'edit'])
    @include("conversations.item.address-modal", ['type' => 'edit'])
    @include('conversations.item.scripts')
</x-app-layout>
