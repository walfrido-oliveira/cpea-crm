<x-app-layout>
  <div class="py-6 show-employees">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
      <div class="flex md:flex-row flex-col">
        <div class="w-full flex items-center">
          <h1>{{ __('Detalhes do Colaborador') }}</h1>
        </div>
        <div class="w-full flex justify-end">
          <div class="m-2 ">
            <a class="btn-outline-info" href="{{ route('employees.index') }}">{{ __('Listar') }}</a>
          </div>
          @if(auth()->user()->hasRole('admin'))
            <div class="m-2">
              <a class="btn-outline-warning" href="{{ route('employees.edit', ['employee' => $employee->id]) }}">{{
                __('Editar') }}</a>
            </div>
            <div class="m-2">
              <button type="button" class="btn-outline-danger delete-employee" id="employee_delete" data-toggle="modal"
                data-target="#delete_modal" data-id="{{ $employee->id }}">{{ __('Apagar') }}</button>
            </div>
          @endif
        </div>
      </div>

      <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
        <div class="mx-4 px-3 py-2 mt-4">
          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('ID') }}</p>
            </div>

            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->id }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Matrícula') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->employee_id }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Colaborador') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->name }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Gestor Imediato') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->manager ? $employee->manager->full_name : '-' }}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Data de Cadastro') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->created_at->format('d/m/Y H:i:s')}}</p>
            </div>
          </div>

          <div class="flex flex-wrap">
            <div class="w-full md:w-2/12">
              <p class="font-bold">{{ __('Última Edição') }}</p>
            </div>
            <div class="w-full md:w-1/2">
              <p class="text-gray-500 font-bold">{{ $employee->updated_at->format('d/m/Y H:i:s')}}</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <x-modal title="{{ __('Excluir departamento') }}" msg="{{ __('Deseja realmente apagar esse departamento?') }}"
    confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_employee_modal" method="DELETE"
    url="{{ route('employees.destroy', ['employee' => $employee->id]) }}"
    redirect-url="{{ route('employees.index') }}" />

  <script>
    function eventsDeleteCallback() {
            document.querySelectorAll('.delete-employee').forEach(item => {
            item.addEventListener("click", function() {
                var modal = document.getElementById("delete_employee_modal");
                modal.classList.remove("hidden");
                modal.classList.add("block");
            })
        });
        }

        eventsDeleteCallback();
  </script>
</x-app-layout>
