<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="cpea_linked_id" columnText="{{ __('IDCPEA') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="customers.name" columnText="{{ __('Cliente') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="" columnText="{{ __('Produto') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="employee_id" columnText="{{ __('Gestor') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="direction_id" columnText="{{ __('Diretoria') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="department_id" columnText="{{ __('Departamento') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="conversation_status_id" columnText="{{ __('Status') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="conversation_items.created_at" columnText="{{ __('Data da Interação') }}" />
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName=""  columnText="{{ __('Valor') }}" />
    </tr>
</thead>
<tbody id="conversations_table_content">
    @forelse ($conversationItems as $key => $conversation)
        <tr>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->cpea_linked_id }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->conversation->customer->name }}
                </a>
            </td>
            <td>
                <a class="text-item-table"  href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    @foreach ($conversation->products as $key => $product)
                        {{ $product->name }}
                    @endforeach
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->employee ? $conversation->employee->user->full_name : '-' }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->direction ? $conversation->direction->name : '-' }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->employee ? $conversation->employee->department_id : '-' }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->conversationStatus->name }}
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('customers.conversations.item.show', ['item' => $conversation->id]) }}">
                    {{ $conversation->created_at->format('d/m/Y H:i') }}
                </a>
            </td>
            <td>
                @if ($conversation->item_type == 'Proposta')
                    R$ {{ number_format($conversation->totalValues('proposed'), 2, ',', '.') }}
                @else
                    -
                @endif
            </td>
        <tr>
        @empty
        <tr>
            <td class="text-center" colspan="5">{{ __('Nenhum resultado encontrado') }}</td>
        </tr>
    @endforelse
<tbody>
