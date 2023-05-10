@foreach ($child->conversations as $conversation)
    <tr>
        <td>
            <a class="text-green-600 underline font-bold" href="{{ route('customers.conversations.show', ['conversation' => $conversation->id]) }}">
                {{ str_pad($conversation->id, 5, 0, STR_PAD_LEFT) }}
            </a>
        </td>
        @if(!$customer->customer_id)
            <td>{{ $conversation->customer->name }}</td>
        @endif
        <td>
            {{ $conversation->cpea_id }}
        </td>
        <td></td>
        <td>
            @php
                $isAdditive = false;
            @endphp
            @foreach ($conversation->items as $item)
                @php if($item->additive) $isAdditive = true; @endphp
            @endforeach
            <span class="w-24 py-1 @if($isAdditive) badge-success @else badge-danger @endif" >
                {{ $isAdditive ? "Sim" : "Não" }}
            </span>
        </td>
        <td>
            @foreach ($conversation->items as $item)
                @foreach ($item->products as $product)
                    {{ $product->name }}<br>
                @endforeach
            @endforeach
        </td>
        <td>{{ $conversation->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ $conversation->updated_at->format('d/m/Y H:i') }}</td>
        <td>

            @if(count($conversation->items) > 0)
                @if($conversation->items[count($conversation->items) - 1]->projectStatus)
                    {{ $conversation->items[count($conversation->items) - 1]->projectStatus->name }}
                @endif

                @if($conversation->items[count($conversation->items) - 1]->proposedStatus)
                    {{ $conversation->items[count($conversation->items) - 1]->proposedStatus->name }}
                @endif

                @if($conversation->items[count($conversation->items) - 1]->prospectingStatus)
                    {{ $conversation->items[count($conversation->items) - 1]->prospectingStatus->name }}
                @endif
            @endif
        </td>
    </tr>
@endforeach
