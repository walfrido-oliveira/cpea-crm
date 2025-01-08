<x-app-layout>
  <div class="py-6 show-customers">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
      <div class="flex md:flex-row flex-col">
        <div class="w-full flex items-center">
          <h1>{{ $customer->customer_id ? "Empresa" : "Cliente" }} - {{ $customer->name }}</h1>
        </div>
        <div class="w-full flex justify-end">
          <div class="m-2 ">
            <a class="btn-outline-info"
              href="{{ !$customer->customer_id ? route('customers.index') : route('customers.show', ['customer' => $customer->customer_id]) }}">
              {{ !$customer->customer_id ? __('Listar') : __('Voltar') }}
            </a>
          </div>
          @if(auth()->user()->hasRole('admin'))
            <div class="m-2">
              <a class="btn-outline-warning" href="{{ route('customers.edit', ['customer' => $customer->id]) }}">{{ __('Editar') }}</a>
            </div>
            <div class="m-2">
              <button type="button" class="btn-outline-danger delete-customer" id="customer_delete" data-toggle="modal"
                data-target="#delete_modal" data-id="{{ $customer->id }}">{{ __('Apagar') }}</button>
            </div>
          @endif
        </div>
      </div>

      <div class="py-2 my-2 bg-white rounded-lg" x-data="showInfos()">
        <div class="mx-4 px-3 py-2 mt-4">
          <div class="flex mb-4">
            <h2 class="w-full">Dados {{ ($customer->customer_id ? "da Empresa" : "do Cliente") }}</h2>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
              <button class="btn-transition-primary" type="button" id="show_all_infos"
                @click="isOpen() ? close() : show();">
                <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }"
                  class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                </svg>
              </button>
            </div>
          </div>
          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Cód.') }} {{ ($customer->customer_id ? "Empresa" : "Cliente") }}</p>
            </div>

            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $customer->id }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Nome') }} {{ ($customer->customer_id ? "da Empresa" : "do Cliente") }}</p>
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
              <p class="font-bold">{{ __('Segmento') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $customer->segment ? $customer->segment->name : '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Novo Cliente') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">
                <span class="w-24 py-1 {{ $customer->is_new_customer ? 'badge-success' : 'badge-danger' }}">{{
                  $customer->is_new_customer ? 'Sim' : 'Não' }}</span>
              </p>
            </div>
          </div>
        </div>

        <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
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
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ?
                $customer->addresses[0]->formatted_cep : '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Endereço') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->address :
                '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Número') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->number :
                '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Complmento') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->complement
                : '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Bairro') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->district :
                '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Cidade') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->city : '-'
                }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Estado (UF)') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ isset($customer->addresses[0]) ? $customer->addresses[0]->state :
                '-' }}</p>
            </div>
          </div>

        </div>

        <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-90 hidden">
          <div class="flex flex-wrap mb-4">
            <h2>Contatos Públicos</h2>
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

        <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
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

        <div class="mx-4 px-3 py-2 mt-4" x-show="isOpen()" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
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
              <p class="text-gray-500 font-bold">{{ $customer->updatedUser ? $customer->updatedUser->full_name : "-" }}
              </p>
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
        <div class="mx-4 px-3 py-2 mt-4" x-data="showMoreContacts()">
          <div class="w-full flex">
            <h2 class="w-full">Contatos {{ ($customer->customer_id ? "da Empresa" : "do Cliente") }}</h2>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
              @if(auth()->user()->hasRole('admin'))
                <a class="btn-outline-info" href="{{ route('customers.detailed-contacts.create', ['customer' => $customer->id ]) }}" id="add_contact">
                  Nova contato
                </a>
              @endif
            </div>
          </div>
          @foreach ($customer->detailedContats as $index => $contact)
          <div class="w-full flex mb-3" @if($index> 4)
            x-show="isOpenContact()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90 hidden"
            @endif>
            <div class="w-full flex" x-data="{showContacts: false}">
              <div class="w-full">
                <div class="flex flex-wrap">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Nome') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->contact }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Cargo') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{$contact->role }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('E-mail') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->mail }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('telefone') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->phone }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Celular') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->cell_phone }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Linkedin') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->linkedin }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Nome Secretária') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->secretary }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Telefone Secretária') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->phone_secretary }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap" x-show="showContacts" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100"
                  x-transition:leave="transition ease-in duration-300"
                  x-transition:leave-start="opacity-100 transform scale-100"
                  x-transition:leave-end="opacity-0 transform scale-90 hidden">
                  <div class="w-full md:w-2/12">
                    <p class="font-bold">{{ __('Observações') }}</p>
                  </div>
                  <div class="w-full md:w-1/2">
                    <p class="text-gray-500 font-bold">{{ $contact->obs }}</p>
                  </div>
                </div>
              </div>
              <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0 flex justify-center place-items-start mt-2">
                <button class="btn-transition-primary" type="button" id="show_all_infos"
                  @click="showContacts = !showContacts" style="position: relative;left: 70px;">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" :class="{ 'rotate-180': showContacts, 'rotate-0': !showContacts }"
                    class="h-6 w-6 inline">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                  </svg>
                </button>
                @if(auth()->user()->hasRole('admin'))
                  <a class="btn-transition-warning"
                    href="{{ route('customers.detailed-contacts.edit', ['detailed_contact' => $contact->id]) }}"
                    style="position: relative;left: 70px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </a>
                  <button class="btn-transition-danger delete-contacts"
                    data-url="{!! route('customers.detailed-contacts.destroy', ['detailed_contact' => $contact->id]) !!}"
                    style="position: relative;left: 70px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                @endif
              </div>
            </div>
            <hr>
          </div>
          @endforeach
          @if(count($customer->detailedContats) > 4)
          <div class="w-full flex justify-center">
            <button class="btn-transition-secondary" type="button" id="show_all_contacts"
              @click="isOpenContact() ? closeContact() : showContact();">
              <span x-show="isOpenContact()">
                {{ __('Mostra menos contatos') }}
              </span>
              <span x-show="!isOpenContact()">
                {{ __('Mostra todos contatos') }}
              </span>
              <svg xmlns="http://www.w3.org/2000/svg"
                :class="{ 'rotate-180': isOpenContact(), 'rotate-0': !isOpenContact() }" class="h-6 w-6 inline"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
              </svg>
            </button>
          </div>
          @endif
        </div>
      </div>

      <div class="py-2 my-2 bg-white rounded-lg" x-data="{ showInterations: false }">
        <div class="mx-4 px-3 py-2 mt-4">
          <div class="w-full flex">
            <h2 class="w-full">Negociações</h2>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                <button class="btn-transition-primary" type="button" id="show_all_infos"
                  @click="showInterations ? showInterations = false : showInterations = true;">
                  <svg xmlns="http://www.w3.org/2000/svg"
                    :class="{ 'rotate-180': showInterations, 'rotate-0': !showInterations }" class="h-6 w-6 inline"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                  </svg>
                </button>
              </div>
              <form method="POST" action="{{ route('customers.conversations.store') }}">
                @csrf
                @method("POST")
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <button type="submit" class="btn-outline-info" id="add_conversation">
                  Nova Conversa
                </button>
              </form>
            </div>
          </div>
          <div class="flex flex-wrap mt-2 table-responsive">
            <table class="table-contacts table md:table w-full">
              <thead>
                <tr class="thead-light">
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Cód. da Interação') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Cliente') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Empresa') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('IDCPEA') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Aditivo?') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('IDCPEA Vinculado') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Produtos') }}</th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Data da Primeira Interação') }}
                  </th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Data da Última Interação') }}
                  </th>
                  <th scope="col" class="custom-th" style="text-align: center;">{{ __('Status da Última Interação') }}
                  </th>
                </tr>
              </thead>
              <tbody>
                @php $index = 0 @endphp
                @foreach ($customer->customers as $key => $child)
                @foreach ($child->conversations()->orderBy("created_at", "desc")->get() as $key => $conversation)
                @include('customers.conversation', ['conversation' => $conversation, 'index' => $index])
                @php $index++ @endphp
                @endforeach
                @endforeach
                @foreach ($customer->conversations()->orderBy("created_at", "desc")->get() as $key => $conversation)
                @include('customers.conversation', ['conversation' => $conversation, 'index' => $index])
                @php $index++ @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      @if(!$customer->customer_id)
      <div class="py-2 my-2 bg-white rounded-lg">
        <div class="mx-4 px-3 py-2 mt-4">
          <div class="w-full flex">
            <h2 class="w-full" id="empresas">Filiais/Unidades de Negócios</h2>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
              @if(auth()->user()->hasRole('admin'))
                <a class="btn-outline-info" href="{{ route('customers.create', ['customer' => $customer->id ]) }}" id="add_customer">
                  Nova Filiais/Unidades
                </a>
              @endif
            </div>
          </div>
          <div class="flex flex-wrap mt-2">
            <table class="table-companys table table-responsive md:table w-full">
              <thead>
                <tr class="thead-light">
                  <th scope="col" class="custom-th">{{ __('Empresa') }}</th>
                  <th scope="col" class="custom-th">{{ __('Cidade') }}</th>
                  <th scope="col" class="custom-th">{{ __('UF') }}</th>
                  <th scope="col" class="custom-th">{{ __('Telefone') }}</th>
                  <th scope="col" class="custom-th">{{ __('Segmento') }}</th>
                  <th scope="col" class="custom-th">{{ __('Última Interração') }}</th>
                  <th scope="col" class="custom-th">{{ __('Situação') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($customer->customers as $child)
                <tr>
                  <td>
                    <a class="text-green-600 underline font-bold"
                      href="{{ route('customers.show', ['customer' => $child->id ]) }}">{{ $child->name }}</a>
                  </td>
                  <td>{{ $child->addresses[0]->city }}</td>
                  <td>{{ $child->addresses[0]->state }}</td>
                  <td>{{ $child->addresses[0]->state }}</td>
                  <td>{{ $child->segment ? $child->segment->name : '-' }}</td>
                  <td>{{ $child->updated_at->format('d/m/Y H:i') }}</td>
                  <td>
                    <span class="w-24 py-1 @if($child->status == " active") badge-success @elseif($child->status ==
                      'inactive') badge-danger @endif" >
                      {{ __($child->status) }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>

  <x-modal title="{{ __('Excluir Cliente') }}" msg="{{ __('Deseja realmente apagar esse cliente?') }}"
    confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_customer_modal" method="DELETE"
    url="{{ route('customers.destroy', ['customer' => $customer->id]) }}"
    redirect-url="{{ route('customers.index') }}" />

  <x-modal title="{{ __('Excluir Contato') }}" msg="{{ __('Deseja realmente apagar esse contato?') }}"
    confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_contact_modal" confirm_id="confirm_contact"
    cancel_modal="cancel_contact" method="DELETE"
    redirect-url="{{ route('customers.show', ['customer' => $customer->id]) }}" />

  <script>
    function eventsDeleteCallback() {
            document.querySelectorAll('.delete-customer').forEach(item => {
                item.addEventListener("click", function() {
                    var modal = document.getElementById("delete_customer_modal");
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                });
            });
        }

        function eventsDeleteContactCallback() {
            document.querySelectorAll('.delete-contacts').forEach(item => {
                item.addEventListener("click", function() {
                    var url = this.dataset.url;
                    var modal = document.getElementById("delete_contact_modal");
                    modal.dataset.url = url;
                    modal.classList.remove("hidden");
                    modal.classList.add("block");
                });
            });
        }

        eventsDeleteCallback();
        eventsDeleteContactCallback();

    function showInfos() {
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

    function showInfosContact() {
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

    function showMoreContacts() {
        return {
            open: false,
            showContact() {
                this.open = true;
            },
            closeContact() {
                this.open = false;
            },
            isOpenContact() {
                return this.open === true
            },
        }
    }
  </script>


</x-app-layout>
