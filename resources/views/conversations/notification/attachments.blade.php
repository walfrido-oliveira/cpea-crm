<table class="table">
    <thead>
        <tr>
            <th>Nome do Arquivo</th>
            <th>Observações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attachments as $attachment)
            <tr>
                <td>
                    <a href="{{ $attachment->url }}">{{ $attachment->name }}</a>
                </td>
                <td>
                    {{ $attachment->obs }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
