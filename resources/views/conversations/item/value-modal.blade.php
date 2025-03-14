<div class="fixed z-10 inset-0 overflow-y-auto hidden {{ $type }}" aria-labelledby="modal-title" role="dialog"
  aria-modal="true" id="value_modal" data-id="0" data-row="">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div
            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Novo Valor
            </h3>
            <div class="mt-2">
              <form action="" id="value_modal_form">
                <input type="hidden" name="value_id" id="value_id" value="">
                <div class="flex flex-wrap mt-2 w-full">
                  <div class="w-full pr-3 mb-6 md:mb-1">
                    <x-jet-label for="value_type" value="{{ __('Tipo de valor') }}" required />
                    <x-custom-select :options="array('proposed' => 'Valor CPEA',
                                      'direct_billing' => 'Faturamento Direto',
                                      'technical_assistance' => 'Assessoria Técnica')" value="" name="value_type" id="value_type" class="mt-1" required />
                  </div>
                  <div class="w-full pr-3 mb-6 md:mb-1" style="display: none">
                    <x-jet-label for="description" value="{{ __('Descrição do valor') }}" />
                    <x-jet-input id="description" class="form-control block mt-1 w-full" type="text" value="" name="description" />
                  </div>
                  <div class="w-full pr-3 mb-6 md:mb-1">
                    <x-jet-label for="value" value="{{ __('Valor') }}" required />
                    <x-jet-input id="value" class="form-control block mt-1 w-full" type="text" value="" stype="any" name="value" required />
                  </div>
                  <div class="w-full pr-3 mb-6 md:mb-1">
                    <x-jet-label for="obs" value="{{ __('Observações') }}" />
                    <textarea name="obs" id="obs" cols="30" rows="5"
                      class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control block mt-1 w-full">{{ old('obs') }}</textarea>
                  </div>
                  <div class="w-full pr-3 mb-6 md:mb-1">
                    <label for="additional_value" class="flex items-center">
                      <input id="additional_value" type="checkbox" class="form-checkbox" name="additional_value" value="1">
                      <span class="ml-2 text-sm text-gray-600">{{ __('Valor Adicional') }}</span>
                    </label>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="confirm_value_modal" class="btn-confirm" data-index="" data-row="">
          Confirmar
        </button>
        <button type="button" id="cancel_value_modal" class="btn-cancel">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
