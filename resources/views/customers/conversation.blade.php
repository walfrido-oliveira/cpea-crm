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
            <a class="text-green-600 underline font-bold" href="{{ route('customers.conversations.show', ['conversation' => $conversation->id]) }}">{{ $conversation->cpea_id }}</a>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $conversation->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ $conversation->updated_at->format('d/m/Y H:i') }}</td>
        <td>
            <span class="w-24 py-1 @if($conversation->status == "active") badge-success @elseif($conversation->status == 'inactive') badge-danger @endif" >
                {{ __($conversation->status) }}
            </span>
        </td>
    </tr>
@endforeach
