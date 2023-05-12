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
        <td>
            @if(count($conversation->items) > 0)
                <span class="w-24 py-1 @if($conversation->items[count($conversation->items) - 1]->additive) badge-success @else badge-danger @endif" >
                    {{ $conversation->items[count($conversation->items) - 1]->additive ? "Sim" : "Não" }}
                </span>
            @endif
        </td>
        <td>
            @if(count($conversation->items) > 0)
                {{ $conversation->items[count($conversation->items) - 1]->cpea_linked_id }}
            @endif
        </td>
        <td>
            @if(count($conversation->items) > 0)
                @foreach ($conversation->items[count($conversation->items) - 1]->products as $product)
                    {{ $product->name }}<br>
                @endforeach
            @endif
        </td>
        <td>
            @if(count($conversation->items) > 0)
                {{ $conversation->items[0]->updated_at->format('d/m/Y H:i') }}
            @endif
        </td>
        <td>
            @if(count($conversation->items) > 0)
                {{ $conversation->items[count($conversation->items) - 1]->updated_at->format('d/m/Y H:i') }}
            @endif
        </td>
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
