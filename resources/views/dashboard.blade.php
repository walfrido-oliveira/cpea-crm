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
      </div>
    </div>
  </div>
</x-app-layout>
