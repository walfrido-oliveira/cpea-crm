<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="{{ $attributes['id'] }}" data-url="{{ $attributes['url'] }}" data-elements="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                {{ $attributes['title'] }}
              </h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                    {{ $attributes['msg'] }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="{{isset($attributes['confirm_id']) ? $attributes['confirm_id'] : 'confirm_modal'}}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ $attributes['confirm'] }}
          </button>
          <button type="button" id="{{isset($attributes['cancel_modal']) ? $attributes['cancel_modal'] : 'cancel_modal'}}" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ $attributes['cancel'] }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>

    window.addEventListener("load", function() {
        var modal = document.getElementById("{{ $attributes['id'] }}");

        const respEvent = new Event('resp', {
                                bubbles: true,
                                cancelable: true,
                                composed: false
                                });

        var modalCallback = function (event) {
            var ajax = [];
            var url = document.getElementById("{{ $attributes['id'] }}").dataset.url;
            var token = document.querySelector('meta[name="csrf-token"]').content;
            var method = "{{$attributes['method'] }}";
            var that = this;
            var urls = url != '' ? url.split(',') : [];

            for (let index = 0; index < urls.length; index++) {
                const url = urls[index];

                ajax[index] = new XMLHttpRequest();

                ajax[index].open("POST", url);

                ajax[index].onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax[index].response);

                        toastr.success(resp.message);

                        @if(!isset($attributes['redirect-url']))
                            var elements = document.getElementById("{{ $attributes['id'] }}").dataset.elements;
                            var elementArray = elements.split(',');
                            document.getElementById(elementArray[index]).innerHTML = '';

                            if((index + 1) == urls.length) {
                                document.getElementById("{{isset($attributes['confirm_id']) ? $attributes['confirm_id'] : 'confirm_modal'}}").dispatchEvent(respEvent);
                            }
                        @endif

                        close();
                    } else if(this.readyState == 4 && this.status != 200) {
                        toastr.error("{!! __('Um erro ocorreu a executar essa ação') !!}");
                        close();
                    }
                }

                var data = new FormData();
                data.append('_token', token);
                data.append('_method', method);

                ajax[index].send(data);

            }

            @if(isset($attributes['redirect-url']))
                var url = "{{ $attributes['redirect-url'] }}?";
                @if(isset($attributes['form-id']))
                    document.querySelectorAll("#{{ $attributes['form-id'] }} input").forEach(function (item) {
                        url += `${item.name}=${item.value}&`;
                    });
                    document.querySelectorAll("#{{ $attributes['form-id'] }} select").forEach(function (item) {
                        url += `${item.name}=${item.value}&`;
                    });
                @endif
                window.location.href = url;
            @endif
        }

        function eventsModalCallback() {
            document.getElementById("{{isset($attributes['confirm_id']) ? $attributes['confirm_id'] : 'confirm_modal'}}").addEventListener('click', modalCallback, false);
        }

        eventsModalCallback();

        function close() {
            modal.classList.add("hidden");
            modal.classList.remove("block");
        }

        document.getElementById("{{isset($attributes['cancel_modal']) ? $attributes['cancel_modal'] : 'cancel_modal'}}").addEventListener("click", function(e) {
            close();
        });
    });
</script>
