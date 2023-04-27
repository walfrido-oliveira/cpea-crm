<x-app-layout>
    <div class="py-6 show-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Usuário') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('users.index') }}">{{ __('Listar') }}</a>
                    </div>
                    <div class="m-2">
                        <form method="POST" action="{{ route('users.forgot-password', ['user' => $user->id]) }}">
                            @csrf
                            @method("POST")
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <button type="submit" class="btn-outline-warning">{{ __('Resetar Senha') }}</button>
                        </form>
                    </div>
                    <div class="m-2">
                        <a class="btn-outline-warning" href="{{ route('users.edit', ['user' => $user->id]) }}">{{ __('Editar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-user" id="user_delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $user->id }}">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class=   "text-gray-500 font-bold">{{ $user->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nome') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $user->full_name }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('E-mail') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Telefone') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $user->phone }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Nível de Acesso') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ implode(", ", $rolesResult) }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Situação') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                <span class="w-24 py-1 @if($user->status == "active") badge-success @elseif($user->status == 'inactive') badge-danger @endif" >
                                    {{ __($user->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Cadastro') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $user->created_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Última Edição') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $user->updated_at->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir usuário') }}"
             msg="{{ __('Deseja realmente apagar esse usuário?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_user_modal"
             method="DELETE"
             url="{{ route('users.destroy', ['user' => $user->id]) }}"
             redirect-url="{{ route('users.index') }}"/>

    <script>
        function eventsDeleteCallback() {
            document.querySelectorAll('.delete-user').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_user_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
    </script>
</x-app-layout>
