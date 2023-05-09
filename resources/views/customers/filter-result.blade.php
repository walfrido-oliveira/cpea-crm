<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="id" columnText="{{ __('Cód. Cliente') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Cliente') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="segment_id" columnText="{{ __('Segmento') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="updated_at" columnText="{{ __('Data da Última Interação') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="created_at" columnText="{{ __('Data de Cadastro') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="status" columnText="{{ __('Situaçao') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="customers_table_content">
    @forelse ($customers as $key => $customer)
        <tr>
            <td>
                <input class="form-checkbox customers-url" type="checkbox" name="customers[{{ $customer->id }}]" value="{!! route('customers.destroy', ['customer' => $customer->id]) !!}">
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->id }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->customer->name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->segment->name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->updated_at->format("d/m/Y H:i") }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.show', ['customer' => $customer->id]) }}">{{ $customer->created_at->format("d/m/Y H:i") }}</a>
            </td>
            <td>
                <span class="w-24 py-1 @if($customer->status == "active") badge-success @elseif($customer->status == 'inactive') badge-danger @endif" >
                    {{ __($customer->status) }}
                </span>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('customers.edit', ['customer' => $customer->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-customers" data-url="{!! route('customers.destroy', ['customer' => $customer->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
<tbody>
