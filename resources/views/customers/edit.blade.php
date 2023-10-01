<x-app-layout>
    <div class="py-6 edit-customers">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('customers.update', ['customer' => $customer->id]) }}">
                @csrf
                @method("PUT")
                <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Cliente') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('customers.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Dados do Cliente</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome do Cliente') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" maxlength="255" required autofocus autocomplete="name" value="{{ $customer->name }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="cnpj" value="{{ __('CNPJ') }}" />
                            <x-jet-input id="cnpj" class="form-control block mt-1 w-full" type="text" name="cnpj" maxlength="18" autofocus autocomplete="cnpj" value="{{ $customer->formatted_cnpj }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="corporate_name" value="{{ __('Razão Social') }}" required/>
                            <x-jet-input id="corporate_name" class="form-control block mt-1 w-full" type="text" name="corporate_name" maxlength="255" required autofocus autocomplete="corporate_name" value="{{ $customer->corporate_name }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="customer_id" value="{{ __('Matriz') }}" required/>
                            <x-custom-select :options="$customers" value="{{ $customer->customer ? $customer->customer->id : null }}" name="customer_id" id="customer_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="segment_id" value="{{ __('Segmento') }}" required/>
                            <x-custom-select :options="$segments" value="{{ $customer->segment_id }}" name="segment_id" id="segment_id" class="mt-1"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="status" value="{{ __('Situação do Cliente') }}" required/>
                            <x-custom-select class="mt-1" :options="$status" name="status" id="status" :value="$customer->status" required/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"><h2 class="px-3 mb-6 md:mb-0">Endereço</h2></div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="cep" value="{{ __('CEP') }}" required/>
                            <x-jet-input id="cep" class="form-control block mt-1 w-full" type="text" name="addresses[0][cep]" maxlength="9" required autofocus autocomplete="cep" value="{{ $customer->addresses[0]->formatted_cep}}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="address" value="{{ __('Endereço') }}" required/>
                            <x-jet-input id="address" class="form-control block mt-1 w-full" type="text" name="addresses[0]address" maxlength="255" required autofocus autocomplete="address" value="{{ $customer->addresses[0]->address }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="number" value="{{ __('Número') }}" required/>
                            <x-jet-input id="number" class="form-control block mt-1 w-full" type="text" name="addresses[0]number" maxlength="255" required autofocus autocomplete="number" value="{{ $customer->addresses[0]->number }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="complement" value="{{ __('Complemento') }}"/>
                            <x-jet-input id="complement" class="form-control block mt-1 w-full" type="text" name="addresses[0]complement" maxlength="255" autofocus autocomplete="complement" value="{{ $customer->addresses[0]->complment }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="district" value="{{ __('Bairro') }}" required/>
                            <x-jet-input id="district" class="form-control block mt-1 w-full" type="text" name="addresses[0]district" maxlength="255" required autofocus autocomplete="district" value="{{ $customer->addresses[0]->district }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="city" value="{{ __('Cidade') }}" required/>
                            <x-jet-input id="city" class="form-control block mt-1 w-full" type="text" name="addresses[0]city" maxlength="255" required autofocus autocomplete="city" value="{{ $customer->addresses[0]->city }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="state" value="{{ __('Estado (UF)') }}" required/>
                            <x-custom-select :options="states()" value="{{ $customer->addresses[0]->state }}" name="state" id="state" class="mt-1"/>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <h2 class="w-full px-3 mb-6 md:mb-0">Contatos Gerais</h2>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end align-baseline">
                            <button type="button" class="btn-outline-info add-contact px-1" title="Adicionar Contatos">
                                Cadastrar
                            </button>
                        </div>
                    </div>
                    <div class="flex mx-4 px-3 py-2 mt-4">
                        <div class="w-full">
                            <table class="table-contacts table table-responsive md:table w-full" x-data="showContacts()">
                                <thead>
                                    <tr class="thead-light">
                                        <th scope="col"  class="custom-th">{{ __('Tipo') }}</th>
                                        <th scope="col"  class="custom-th">{{ __('Descrição') }}</th>
                                        <th scope="col"  class="custom-th">{{ __('Data de Cadastro') }}</th>
                                        <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
                                        <th scope="col"  class="custom-th"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customer->contacts as $key => $contact)
                                        @include('customers.contact-content')
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">{{ __('Nenhum contato encontrado') }}</td>
                                        </tr>
                                    @endforelse
                                    @if(count($customer->contacts) > 4)
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                <button class="btn-transition-secondary" type="button" id="show_all_contacts"
                                                    @click="isOpen() ? close() : show();">
                                                    <span x-show="isOpen()">
                                                        {{ __('Mostra menos pedidos') }}
                                                    </span>
                                                    <span x-show="!isOpen()">
                                                        {{ __('Mostra todos pedidos') }}
                                                    </span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        :class="{ 'rotate-180': isOpen(), 'rotate-0': !isOpen() }"
                                                        class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="obs" value="{{ __('Observações') }}"/>
                            <textarea name="obs" id="obs" cols="30" rows="5" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control block mt-1 w-full">{{ $customer->obs }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-0">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label for="competitors" value="{{ __('Concorrentes') }}"/>
                            <x-jet-input id="competitors" class="form-control block mt-1 w-full" type="text" name="competitors" maxlength="255" autofocus autocomplete="competitors" value="{{ $customer->competitors }}"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include("customers.contact-modal")
    @include("customers.delete-contact-modal")
    @include('customers.scripts')
</x-app-layout>
