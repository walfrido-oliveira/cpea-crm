@include('conversations.item.styles')

<x-app-layout>
    <div class="py-6 create-contact-type">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.conversations.item.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Nova interação') }} - {{ $conversation->customer->name }}</h1>
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
                        <div class="w-full md:w-1/2">
                            <h2 class="px-3 mb-6 md:mb-0">Tipo de Interação</h2>
                        </div>
                        <div class="w-full md:w-1/2 justify-end flex text-center" style="min-height: 54px">
                            <div class="@if(!$conversation->cpea_id) hidden @endif">
                                <h2 class="px-3 mb-6 md:mb-0">ID CPEA</h2>
                                <h2 class="px-3 mb-6 md:mb-0 text-green-600" style="font-size: 2rem !important;">{{ $conversation->cpea_id }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap" style="margin-top: -29px;">
                        <div class="w-1/2 custom-radio mx-4 px-1 py-1 mt-0 ml-3 flex items-center" style="max-height: 59px">
                            <div class="bg-gray-200 radios-container">
                                <div class="inline-flex inner-item p-2">
                                    <input type="radio" name="item_type" id="prospect" checked hidden value="Prospect"/>
                                    <label for="prospect" class="radio">Prospect</label>
                                </div>
                                <div class="inline-flex inner-item p-2">
                                    <input type="radio" name="item_type" id="proposta" hidden value="Proposta"/>
                                    <label for="proposta" class="radio">Proposta</label>
                                </div>
                                <div class="inline-flex inner-item p-2">
                                    <input type="radio" name="item_type" id="projeto" hidden value="Projeto"/>
                                    <label for="projeto" class="radio">Projeto</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="py-2 my-2 bg-white rounded-lg conversation_fields">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Dados da Interação</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="interaction_at" value="{{ __('Data/Hora da Interação') }}" required/>
                            <x-jet-input id="interaction_at" class="form-control block mt-1 w-full" type="datetime-local" name="interaction_at" required autofocus value="{{ old('interaction_at') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="prospecting_status_id" value="{{ __('Status da Interação') }}" required/>
                            <x-custom-select :options="$conversationStatuses" value="{{ old('conversation_status_id') }}" required name="conversation_status_id" id="conversation_status_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="detailed_contact_id" value="{{ __('Contato') }}" required/>
                            <x-custom-select :options="$detailedContacts" value="{{ old('detailed_contact_id') }}" required name="detailed_contact_id" id="detailed_contact_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="products" value="{{ __('Produtos') }}"/>
                            <x-custom-multi-select multiple :options="$products" name="products[]" id="products" :value="[]" select-class="form-input" class="" no-filter="no-filter" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="additive" value="{{ __('Aditivo') }}"/>
                            <x-custom-select :options="array('y' => 'Sim', 'n' => 'Não')" value="{{ old('additive') }}" name="additive" id="additive" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cpea_linked_id" value="{{ __('IDCPEA Vinculado') }}"/>
                            <x-custom-select :options="$cpeaIds" value="{{ old('cpea_linked_id') }}" name="cpea_linked_id" id="cpea_linked_id" select-class="no-nice-select no-hide" class="mt-1 no-nice-select" disabled/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields hidden">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="direction_id" value="{{ __('Diretoria') }}"/>
                            <x-custom-select :options="$directions" value="{{ old('direction_id') }}" name="direction_id" id="direction_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="department_id" value="{{ __('Departamento') }}"/>
                            <x-custom-select :options="$departments" name="department_id" id="department_id" class="mt-1" value=""/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="employee_id" value="{{ __('Gestor') }}"/>
                            <x-custom-select :options="$employees" value="{{ old('employee_id') }}" name="employee_id" id="employee_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields hidden">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="etapa_id" value="{{ __('Etapa') }}"/>
                            <x-custom-select :options="$etapas" value="{{ old('etapa_id') }}" name="etapa_id" id="etapa_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="ppi" value="{{ __('PPI') }}"/>
                            <x-custom-select :options="array('y' => 'Sim', 'n' => 'Não')" value="{{ old('ppi') }}" name="ppi" id="ppi" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cnpj_id" value="{{ __('CNPJ') }}"/>
                            <x-custom-select :options="$cnpjs" value="{{ old('cnpj_id') }}" name="cnpj_id" id="cnpj_id" class="mt-1"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 proposed-fields hidden">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="state" value="{{ __('Estado') }}"/>
                            <x-custom-select :options="states()" value="{{ old('state') }}" name="state" id="state" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="city" value="{{ __('Cidade') }}"/>
                            <x-custom-select :options="[]" value="{{ old('city') }}" name="city" id="city" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="probability" value="{{ __('Probabildade') }}"/>
                            <x-custom-select :options="$probabilities" value="{{ old('probability') }}" name="probability" id="probability" class="mt-1"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <h2 class="px-3 mb-6 md:mb-0">Detalhes da Conversa</h2>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <textarea name="item_details" id="item_details" cols="30" rows="5" class="ckeditor" required>{{ old('item_details') }}</textarea>
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
                                <x-custom-select :options="array('internal' => 'Follow up', 'external' => 'Reunião Externa')" value="{{ old('schedule_type') }}" name="schedule_type" id="schedule_type" class="mt-1"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_name" value="{{ __('Nome da Agenda') }}"/>
                                <x-jet-input id="schedule_name" class="form-control block mt-1 w-full" type="text" name="schedule_name" maxlength="255" autofocus autocomplete="schedule_name" value="{{ old('schedule_name') }}"/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-jet-label for="meeting_form" value="{{ __('Forma de Reunião') }}"/>
                                <x-custom-select :options="array('online' => 'Online', 'presential' => 'Presencial')" value="online" name="meeting_form" id="meeting_form" class="mt-1"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 hidden meeting-place">
                                <x-jet-label for="meeting_place" value="{{ __('Local') }}"/>
                                <x-jet-input id="meeting_place" class="form-control block mt-1 w-full" type="text" name="meeting_place" maxlength="255" autofocus autocomplete="meeting_place" value="{{ old('meeting_place') }}"/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 ">
                                <x-jet-label for="teams_url" value="{{ __('Link do Teams') }}"/>
                                <x-jet-input id="teams_url" class="form-control block mt-1 w-full" type="text" name="teams_url" maxlength="255" autofocus autocomplete="teams_url" disabled/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 teams-url">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 ">
                                <x-jet-label for="teams_id" value="{{ __('ID da reunião') }}"/>
                                <x-jet-input id="teams_id" class="form-control block mt-1 w-full" type="text" name="teams_id" maxlength="255" autofocus autocomplete="teams_id" disabled/>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 ">
                                <x-jet-label for="teams_token" value="{{ __('Senha da Reunião') }}"/>
                                <x-jet-input id="teams_token" class="form-control block mt-1 w-full" type="text" name="teams_token" maxlength="255" autofocus autocomplete="teams_token" disabled/>
                            </div>
                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full md:w-1/2  px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_at" value="{{ __('Data/Hora da Reunião') }}"/>
                                <x-jet-input id="schedule_at" class="form-control block mt-1 w-full" type="datetime-local" name="schedule_at" autofocus value="{{ old('schedule_at') }}"/>
                            </div>
                            <div class="w-full md:w-1/2  px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_end" value="{{ __('Data/Hora do Fim da Reunião') }}"/>
                                <x-jet-input id="schedule_end" class="form-control block mt-1 w-full" type="datetime-local" name="schedule_end" autofocus value="{{ old('schedule_end') }}"/>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="schedule_details" value="{{ __('Detalhes do Agendamento') }}"/>
                                <textarea name="schedule_details" id="schedule_details" cols="30" rows="5" class="ckeditor">{{ old('schedule_details') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
      var theEditor;

      ClassicEditor
      .create( document.querySelector( '.ckeditor' ) )
      .then(editor => {
        editor.ui.focusTracker.on( 'change:isFocused', ( evt, name, isFocused ) => {
          if ( !isFocused ) {
            document.querySelector('.ckeditor').value = editor.getData();
          }
        } );
      })
      .catch( error => {
          console.error( error );
      } );
    </script>

    @include("conversations.item.attachment-modal", ['type' => 'create'])
    @include("conversations.item.value-modal", ['type' => 'create'])
    @include("conversations.item.address-modal", ['type' => 'create'])
    @include("conversations.item.item-type-modal")
    @include('conversations.item.scripts')
</x-app-layout>
