<tr @if($key > 2) x-show="isOpen()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90 hidden" @endif>
    <td>
        {{ $contact->generalContactType->name }}
        <input type="hidden" class="general-contact-type-id" data-id="{{ $contact->id }}" value="{{ $contact->general_contact_type_id }}">
    </td>
    <td>
        {{ $contact->description }}
        <input type="hidden" class="contact-description" data-id="{{ $contact->id }}" value="{{ $contact->description }}">
    </td>
    <td>{{ $contact->created_at->format("d/m/Y H:i") }}</td>
    <td>
        {{ $contact->obs }}
        <input type="hidden" class="contact-obs" data-id="{{ $contact->id }}" value="{{ $contact->obs }}">
    </td>
    <td>
        <button class="btn-transition-warning edit-contact" data-id="{{ $contact->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
        <button class="btn-transition-danger delete-contact" data-id="{{ $contact->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </td>
</tr>
