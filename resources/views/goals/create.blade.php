<x-app-layout>
  <div class="py-6 create-goals">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
      <form method="POST" action="{{ route('config.goals.store') }}">
        @csrf
        @method("POST")
        <div class="flex md:flex-row flex-col">
          <div class="w-full flex items-center">
            <h1>{{ __('Meta') }}</h1>
          </div>
          <div class="w-full flex justify-end">
            <div class="m-2 ">
              <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
            </div>
            <div class="m-2">
              <a href="{{ route('config.goals.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
            </div>
          </div>
        </div>

        <div class="flex md:flex-row flex-col">
          <x-jet-validation-errors class="mb-4" />
        </div>

        <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
          <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
            <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
              <x-jet-label for="year" value="{{ __('Ano') }}" required />
              <x-jet-input id="year" class="form-control block  w-full" type="number" name="year" required autofocus autocomplete="year" placeholder="{{ __('Ano') }}" />
            </div>
            <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
              <x-jet-label for="month" value="{{ __('Mês') }}" required />
              <x-custom-select :options="months()" name="month" id="month" :value="app('request')->input('month')" />
            </div>
            <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
              <x-jet-label for="value" value="{{ __('Valor da Meta') }}" required />
              <x-jet-input id="value" class="form-control block w-full" type="number" value="" step="any" name="value" required/>
            </div>
          </div>
          <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <x-jet-label for="direction_id" value="{{ __('Diretoria') }}" required />
              <x-custom-select :options="$directions" name="direction_id" id="direction_id" :value="app('request')->input('direction_id')" />
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <x-jet-label for="department_id" value="{{ __('Departamento') }}" required />
              <x-custom-select :options="$departments" name="department_id" id="department_id" :value="app('request')->input('department_id')" />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>


</x-app-layout>
