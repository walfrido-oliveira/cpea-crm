<thead>
  <tr class="thead-light">
    <th scope="col"  class="custom-th">{{ __('Tipo de valor') }}</th>
    <th scope="col"  class="custom-th">{{ __('Valor') }}</th>
    <th scope="col"  class="custom-th">{{ __('Observações') }}</th>
    <th scope="col"  class="custom-th">{{ __('') }}</th>
  </tr>
</thead>
<tbody>
  @if(isset($conversationItem))
    @foreach ($conversationItem->values as $value)
      <tr>
        <td>
          <input type="hidden" value="{{ $value->value_type }}" class="value-type">
          {{ __($value->value_type) }}
        </td>
        <td>
          R$ {{ number_format($value->value, 2, ",", ".") }}
        </td>
        <td>
          {{ $value->obs }}
        </td>
        <td>
          <button type="button" class="btn-transition-danger delete-value edit"
            data-url="{!! route('customers.conversations.item.values.delete', ['value' => $value->id]) !!}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </button>
        </td>
      </tr>
    @endforeach
  @endif
</tbody>
<tfoot>
  <tr>
    <td>Proposta</td>
    <td id="total_value">
      @if(isset($conversationItem))
        R$ {{ number_format($conversationItem->values()->sum('value'), 2, ",", ".") }}
      @else
        R$ 0,00
      @endif
    </td>
    <td></td>
    <td></td>
  </tr>
</tfoot>
