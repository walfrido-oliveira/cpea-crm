<x-app-layout>
  <div class="py-6 dashboard">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
      <div class="flex md:flex-row flex-col">
        <div class="w-full flex items-center">
          <h1>{{ __('Dashboard') }}</h1>
        </div>
        <div class="w-full flex justify-end">
          <div class="m-2 ">
            <a href="{{ route('customers.conversations.item.faster-create') }}" class="btn-outline-success">{{ __('Nova Interação') }}</a>
          </div>
        </div>
      </div>
      <div class="py-2 my-2 bg-white rounded-lg">
        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 justify-end">
          <div class="w-full md:w-1/6 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="year">
              {{ __('Ano') }}
            </label>
            <x-custom-select class="mt-1" :options="$years" name="year" id="year" :value="now()->format('Y')" />
          </div>
          <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="department_id">
              {{ __('Departamento') }}
            </label>
            <x-custom-select class="mt-1" :options="$departments" name="department_id" id="department_id" :value="app('request')->input('department_id')" />
          </div>
          <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="direction_id">
              {{ __('Diretoria') }}
            </label>
            <x-custom-select class="mt-1" :options="$directions" name="direction_id" id="direction_id" :value="app('request')->input('direction_id')" />
          </div>
        </div>
        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 items-end">
          <div class="w-3/5 p-4 my-2">
            <canvas id="chart-01" style="border: 2px solid #ccc; padding: 5px;"></canvas>
          </div>
          <div class="w-2/5 p-4 my-2">
            <canvas id="chart-02"></canvas>
          </div>
        </div>
        <div class="flex flex-wrap mx-4 px-3 py-2 mt-0 items-end">
          <div class="w-3/5 p-4 my-2">
            <canvas id="chart-03" style="border: 2px solid #ccc; padding: 5px;"></canvas>
          </div>
          <div class="w-2/5 p-4 my-2">
            <canvas id="chart-04"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('dashboard.scripts')
</x-app-layout>
