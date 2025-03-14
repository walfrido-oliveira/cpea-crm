<tr @if($index > 4) x-show="showInterations"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90 hidden" @endif>
    <td class="text-center">
        <a class="text-green-600 underline font-bold" href="{{ route('customers.conversations.show', ['conversation' => $conversation->id]) }}">
            {{ str_pad($conversation->id, 5, 0, STR_PAD_LEFT) }}
        </a>
    </td>
    <td class="text-center">
        @if(!$conversation->customer->customer_id)
            {{ $conversation->customer->name }}
        @else
        {{ $conversation->customer->customer->name }}
        @endif
    </td>
    <td class="text-center">{{ $conversation->customer->customer_id ? $conversation->customer->name : '-' }}</td>
    <td class="text-center">
        {{ $conversation->cpea_id ? $conversation->cpea_id : '-' }}
    </td>
    <td class="text-center">
        @if(count($conversation->items) > 0)
            <span class="w-24 py-1 @if($conversation->items[count($conversation->items) - 1]->additive) badge-success @else badge-danger @endif">
                {{ $conversation->items[count($conversation->items) - 1]->additive ? "Sim" : "Não" }}
            </span>
        @endif
    </td>
    <td class="text-center">
        @if(count($conversation->items) > 0)
            {{ $conversation->items[count($conversation->items) - 1]->cpea_linked_id ? $conversation->items[count($conversation->items) - 1]->cpea_linked_id : '-' }}
        @endif
    </td>
    <td class="text-center produtos">
        @if(count($conversation->items) > 0)
            @foreach ($conversation->items[count($conversation->items) - 1]->products as $key => $product)
                <div @if($key > 0) class="more" @endif>{{ $product->name }}</div>
            @endforeach
        @endif
    </td>
    <td class="text-center">
        @if(count($conversation->items) > 0)
            {{ $conversation->items[0]->interaction_at->format('d/m/Y H:i') }}
        @endif
    </td>
    <td class="text-center">
        @if(count($conversation->items) > 0)
            {{ $conversation->items[count($conversation->items) - 1]->interaction_at->format('d/m/Y H:i') }}
        @endif
    </td>
    <td class="text-center">
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
