<thead>
    <tr class="thead-light">
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="id" columnText="{{ __('#') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="name" columnText="{{ __('Nome') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="email" columnText="{{ __('Email') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="role" columnText="{{ __('Nível') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="status" columnText="{{ __('STatus') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="created_at" columnText="{{ __('DT Cadastro') }}"/>
        <x-table-sort-header :orderBy="$orderBy" :ascending="$ascending" columnName="updated_at" columnText="{{ __('DT Atualização') }}"/>
        <th scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Ações
        </th>
    </tr>
</thead>
<tbody id="users_table_content">
    @forelse ($users as $key => $user)
        <tr>
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->id }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->full_name }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->email }}</a>
            </td>
            @php
                $roles = $user->roles->pluck("name")->all();
                $rolesResult = [];
                foreach ($roles as $key => $value)
                {
                    $rolesResult[ $key ] = __($value);
                }
            @endphp
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ implode(", ", $rolesResult) }}</a>
            </td>
            <td>
                <span class="w-24 py-1 @if($user->status == "active") badge-success @elseif($user->status == 'inactive') badge-danger @endif" >
                    {{ __($user->status) }}
                </span>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->created_at ? $user->created_at->format("d/m/Y") : '-' }}</a>
            </td>
            <td>
                <a class="text-item-table" href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->updated_at ? $user->updated_at->format("d/m/Y") : '-' }}</a>
            </td>
            <td>
                <a class="btn-transition-warning" href="{{ route('users.edit', ['user' => $user->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <button class="btn-transition-danger delete-user" data-url="{!! route('users.destroy', ['user' => $user->id]) !!}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        <tr>
    @empty
        <tr>
            <td class="text-center" colspan="5">{{ __("Nenhum usuário encontrado") }}</td>
        </tr>
    @endforelse
</tbody>
