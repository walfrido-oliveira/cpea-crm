<table>
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Nome do Contato</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>Celular</th>
      <th>Cargo</th>
      <th>Linkedin</th>
      <th>Nome da Secretária</th>
      <th>Email da Secretária</th>
      <th>Telefone da Secretária</th>
      <th>Celular da Secretária</th>
      <th>Observações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($contacts as $contact)
      <tr>
        <td>{{ $contact->customer->name }}</td>
        <td>{{ $contact->contact }}</td>
        <td>{{ $contact->mail }}</td>
        <td>{{ $contact->phone }}</td>
        <td>{{ $contact->cell_phone }}</td>
        <td>{{ $contact->role }}</td>
        <td>{{ $contact->linkedin }}</td>
        <td>{{ $contact->secretary }}</td>
        <td>{{ $contact->mail_secretary }}</td>
        <td>{{ $contact->phone_secretary }}</td>
        <td>{{ $contact->obs }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
