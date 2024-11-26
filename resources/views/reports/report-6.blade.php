<table>
  <thead>
    <tr>
      <th>Nº CONVERSA</th>
      <th>Nº INTERAÇÃO</th>
      <th>IDCPEA</th>
      <th>DATA/HORA INTERAÇÃO</th>
      <th>DATA/HORA SISTEMA</th>
      <th>FLAG VALOR ADICIONAL</th>
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
      <th>CNPJ CPEA</th>
      <th>ESTADO</th>
      <th>CIDADE</th>
      <th>DESCRIÇÃO</th>
      <th>VALOR CPEA (R$)</th>
      <th>DESCRIÇÃO VALOR CPEA</th>
      <th>FATURAMENTO DIRETO (R$)</th>
      <th>DESCRIÇÃO FATURAMENTO DIRETO</th>
      <th>ASSESSORIA TÉCNICA (R$)</th>
      <th>DESCRIÇÃO ASSESSORIA TÉCNICA</th>
      <th>VALOR PROPOSTA (R$)</th>
      <th>FATURAMENTO DIRETO (OPÇÃO)</th>
      <th>ASSESSORIA TÉCNICA (OPÇÃO)</th>
      <th>RESPONSÁVEL PELA INTERAÇÃO</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($conversations as $conversation)
    <tr>
      <td>{{ $conversation->conversation->id }}</td>
      <td>{{ str_pad($conversation->id, 5, 0, STR_PAD_LEFT) }}</td>
      <td>{{ $conversation->conversation->cpea_id ? $conversation->conversation->cpea_id : '-' }}</td>
      <td>{{ $conversation->interaction_at->format('d/m/Y H:i:s') }}</td>
      <td>{{ $conversation->created_at->format('d/m/Y H:i:s') }}</td>
      <td>{{ count($conversation->values()->where('additional_value', true)->get()) > 0 ? 'SIM' : 'NÃO' }}</td>
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
      <td>
        @if($conversation->employee)
          {{ $conversation->department ? $conversation->department->name : '-' }}
        @endif
      </td>
      <td>{{ $conversation->employee ? $conversation->employee->name : '-' }}</td>
      <td>{{ $conversation->etapa ? $conversation->etapa->name : '-' }}</td>
      <td>{{ __($conversation->ppi) }}</td>
      <td>{{ $conversation->cnpj ? $conversation->cnpj->formatted_cnpj : '-' }}</td>
      <td>{{ $conversation->state ? $conversation->state : '-' }}</td>
      <td>{{ $conversation->city ? $conversation->city : '-' }}</td>
      <td>{{ Str::length(strip_tags($conversation->item_details)) > 100 ?
      Str::substr(strip_tags($conversation->item_details), 0, 100) . ' [...]' : strip_tags($conversation->item_details)  }}</td>
      <td>
        R$ {{ number_format($conversation->values()->where('value_type', 'proposed')->sum('value'), 2, ",", ".") }}
      </td>
      <td>
        {{ $conversation->values()->where('value_type', 'proposed')->first() ?
        $conversation->values()->where('value_type', 'proposed')->first()->obs : '-' }}
      </td>
      <td>
        R$ {{ number_format($conversation->values()->where('value_type', 'direct_billing')->sum('value'), 2, ",", ".") }}
      </td>
      <td>
        {{ $conversation->values()->where('value_type', 'direct_billing')->first() ?
        $conversation->values()->where('value_type', 'direct_billing')->first()->obs : '-' }}
      </td>
      <td>
        R$ {{ number_format($conversation->values()->where('value_type', 'technical_assistance')->sum('value'), 2, ",", ".") }}
      </td>
      <td>
        {{ $conversation->values()->where('value_type', 'technical_assistance')->first() ?
        $conversation->values()->where('value_type', 'technical_assistance')->first()->obs : '-' }}
      </td>
      <td>
        R$ {{ number_format($conversation->values()->sum('value'), 2, ",", ".") }}
      </td>
      <td>
        {{ count($conversation->values()->where('value_type', 'direct_billing')->get()) > 0 ? 'SIM' : 'NÃO' }}
      </td>
      <td>
        {{ count($conversation->values()->where('value_type', 'technical_assistance')->get()) > 0 ? 'SIM' : 'NÃO' }}
      </td>
      <td>{{ $conversation->user->full_name }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
