<table>
  <thead>
    <tr>
      <th>Nome</th>
      <th>CNPJ</th>
      <th>Razão Social</th>
      <th>Segmento</th>
      <th>Novo Cliente?</th>
      <th>CEP</th>
      <th>Endereço</th>
      <th>Número</th>
      <th>Complemento</th>
      <th>Bairro</th>
      <th>Cidade</th>
      <th>Estado</th>
      <th>Observações</th>
      <th>Concorrentes</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($customers as $customer)
      <tr>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->cnpj ? $customer->formatted_cnpj : "-" }}</td>
        <td>{{ $customer->corporate_name }}</td>
        <td>{{ $customer->segment ? $customer->segment->name : '-' }}</td>
        <td>{{ $customer->is_new_customer ? 'Sim' : 'Não' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->formatted_cep : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->address : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->number : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->complement : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->district : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->city : '-' }}</td>
        <td>{{ isset($customer->addresses[0]) ? $customer->addresses[0]->state : '-' }}</td>
        <td>{{$customer->obs }}</td>
        <td>{{$customer->competitors }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
