<table>
    <thead>
      <tr>
        <th>Nº</th>
        <th>IDCPEA</th>
        <th>DATA/HORA</th>
        <th>TIPO</th>
        <th>STATUS</th>
        <th>PROBABILIDADE</th>
        <th>CLIENTE</th>
        <th>SEGMENTO</th>
        <th>NOVO CLIENTE?</th>
        <th>CONTATO</th>
        <th>PRODUTOS</th>
        <th>ADITIVO?</th>
        <th>IDCPEA VINCULADO</th>
        <th>DIRETORIA</th>
        <th>DEPARTAMENTO</th>
        <th>GESTOR</th>
        <th>ETAPA</th>
        <th>PPI</th>
        <th>CNPJ</th>
        <th>ESTADO</th>
        <th>CIDADE</th>
        <th>VALORES</th>
        <th>DESCRIÇÃO</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($conversations as $conversation)
      <tr>
        <td>{{ str_pad($conversation->id, 5, 0, STR_PAD_LEFT) }}</td>
        <td>{{ $conversation->cpea_linked_id ? $conversation->cpea_linked_id : '-' }}</td>
        <td>{{ $conversation->interaction_at->format('d/m/Y H:i:s') }}</td>
        <td>{{ $conversation->item_type }}</td>
        <td>{{ $conversation->conversationStatus ? $conversation->conversationStatus->name : "-" }}</td>
        <td>{{ $conversation->probability ? $conversation->probability : '-' }}</td>
        <td>{{ $conversation->conversation->customer ? $conversation->conversation->customer->name : '-' }}</td>
        <td>
          @if ($conversation->conversation->customer)
            {{ $conversation->conversation->customer->segment ? $conversation->conversation->customer->segment->name : '-' }}
          @endif
        </td>
        <td>
          @if ($conversation->conversation->customer)
            {{ $conversation->conversation->customer->is_new_customer ? 'Sim' : 'Não' }}
          @endif
        </td>
        <td>{{ $conversation->detailedContact ? $conversation->detailedContact->contact : '-' }}</td>
        <td>
          @foreach ($conversation->products as $key => $product)
            {{ $product->name }} @if(count($conversation->products) - 1 < $key),@endif
          @endforeach
        </td>
        <td>{{ $conversation->additive ? "Sim" : "Não" }}</td>
        <td>{{ $conversation->cpea_linked_id ? $conversation->cpea_linked_id : '-' }}</td>
        <td>{{ $conversation->direction ? $conversation->direction->name : '-' }}</td>
        <td>{{ $conversation->employee ? $conversation->employee->department->name : '-' }}</td>
        <td>{{ $conversation->employee ? $conversation->employee->full_name : '-' }}</td>
        <td>{{ $conversation->etapa ? $conversation->etapa->name : '-' }}</td>
        <td>{{ __($conversation->ppi) }}</td>
        <td>
            @if ($conversation->conversation->customer)
                {{ $conversation->conversation->customer->cnpj ? $conversation->conversation->customer->formatted_cnpj : '-' }}
            @endif
        </td>
        <td>{{ $conversation->state ? $conversation->state : '-' }}</td>
        <td>{{ $conversation->city ? $conversation->city : '-' }}</td>
        <td>
            @foreach ($conversation->values as $key => $value)
                <p>TIPO DE VALOR: {{ __($value->value_type) }}, DESCRIÇÃO: {{ $value->description }}, VALOR: R$ {{ number_format($value->value, 2, ",", ".") }}</p>
            @endforeach
        </td>
        <td>{{ strip_tags($conversation->item_details) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
