<table class="table">
    <thead>
        <tr>
            <th>Tipo de valor</th>
            <th>Descrição do valor</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($values as $value)
            <tr>
                <td>
                    {{ __($value->value_type) }}
                </td>
                <td>
                    {{ $value->description }}
                </td>
                <td>
                    R$ {{ number_format($value->value, 2, ",", ".") }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
