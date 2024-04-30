<table>
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Tipo</th>
      <th>Descrição</th>
      <th>Data de Cadastro</th>
      <th>Observações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($contacts as $contact)
      <tr>
        <td>{{ $contact->customer->name }}</td>
        <td>{{ $contact->generalContactType->name }}</td>
        <td>{{ $contact->description }}</td>
        <td>{{ $contact->created_at->format('d/m/y') }}</td>
        <td>{{ $contact->obs }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
