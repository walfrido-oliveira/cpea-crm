<thead>
  <tr class="thead-light">
    <x-table-sort-header :orderBy="null" :ascending="null" columnName="" columnText="{{ __('') }}" />
    <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="year" columnText="{{ __('Ano') }}" />
    <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="month" columnText="{{ __('Mês') }}" />
    <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="direction_id" columnText="{{ __('Diretoria') }}" />
    <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="department_id" columnText="{{ __('Departamento') }}" />
    <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="value" columnText="{{ __('Valor da Meta') }}" />
    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
      Ações
    </th>
  </tr>
</thead>
<tbody id="etapas_table_content">
  @forelse ($goals as $key => $goal)
  <tr>
    <td>
      <input class="form-checkbox goals-url" type="checkbox" name="goals[{{ $goal->id }}]" value="{!! route('config.goals.destroy', ['goal' => $goal->id]) !!}">
    </td>
    <td>
      <a class="text-item-table" href="{{ route('config.goals.show', ['goal' => $goal->id]) }}">{{ $goal->year }}</a>
    </td>
    <td>
      <a class="text-item-table" href="{{ route('config.goals.show', ['goal' => $goal->id]) }}">{{ months()[$goal->month] }}</a>
    </td>
    <td>
      <a class="text-item-table" href="{{ route('config.goals.show', ['goal' => $goal->id]) }}">{{ $goal->direction->name }}</a>
    </td>
    <td>
      <a class="text-item-table" href="{{ route('config.goals.show', ['goal' => $goal->id]) }}">{{ $goal->department->name }}</a>
    </td>
    <td>
      <a class="text-item-table" href="{{ route('config.goals.show', ['goal' => $goal->id]) }}">R$ {{ number_format($goal->value, 2, ",", ".") }}</a>
    </td>
    <td>
      <a class="btn-transition-warning" href="{{ route('config.goals.edit', ['goal' => $goal->id]) }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
      </a>
      <button class="btn-transition-danger delete-goals" data-url="{!! route('config.goals.destroy', ['goal' => $goal->id]) !!}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
