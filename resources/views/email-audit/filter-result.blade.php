<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="subject" columnText="{{ __('Assunto') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="to" columnText="{{ __('Para') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="created_at" columnText="{{ __('Data do envio') }}"/>
    </tr>
</thead>
<tbody id="email_audit_table_content">
    @forelse ($emailAudit as $key => $email)
        <tr>
            <td>
                <a class="text-item-table" href="{{ route('config.emails.email-audit.show', ['email_audit' => $email->id]) }}">{{ $email->subject }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('config.emails.email-audit.show', ['email_audit' => $email->id]) }}">
                    @foreach ($email->to as $to)
                        {{ $to }} <br>
                    @endforeach
                </a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('config.emails.email-audit.show', ['email_audit' => $email->id]) }}">{{
                    $email->created_at->format('d/m/Y H:i:s') }}
                </a>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum resultado encontrado") }}</td>
        </tr>
    @endforelse
<tbody>
