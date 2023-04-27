<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Tipo Contato Geral') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="general_contact_type_table_content">
    @forelse ($generalContactTypes as $key => $generalContactType)
        <tr>
            <td>
                <input class="form-checkbox general-contact-types-url" type="checkbox" name="general-contact-types[{{ $generalContactType->id }}]" value="{!! route('general-contact-types.destroy', ['general_contact_type' => $generalContactType->id]) !!}">
            </td>
            <td>
                <a class="text-item-table" href="{{ route('general-contact-types.show', ['general_contact_type' => $generalContactType->id]) }}">{{ $generalContactType->name }}</a>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('general-contact-types.edit', ['general_contact_type' => $generalContactType->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-general-contact-types" data-url="{!! route('general-contact-types.destroy', ['general_contact_type' => $generalContactType->id]) !!}">
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
