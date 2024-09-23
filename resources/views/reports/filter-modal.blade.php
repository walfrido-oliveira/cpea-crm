<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true"
  id="filter_modal" data-id="0" data-row="">
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
              Filtro
            </h3>
            <div class="mt-2">
              <form action="" id="filter_modal_form">
                <div class="flex flex-wrap mt-2 w-full">
                  <div class="w-full pr-3 mb-6 md:mb-1">
                    <x-jet-label for="start_date" value="{{ __('Intervalo de data') }}" />
                    <div class="flex gap-2">
                      <x-jet-input id="start_date" class="form-control block mt-1 w-full" type="date" value=""
                        name="start_date" />
                      <x-jet-input id="end_date" class="form-control block mt-1 w-full" type="date" value=""
                        name="end_date" />
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <a id="confirm_filter_modal" class="btn-confirm" href="#" data-root="" data-reportname="">
          Confirmar
        </a>
        <button type="button" id="cancel_filter_modal" class="btn-cancel">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleFilterModal(show = false) {
    const modal = document.querySelector("#filter_modal");
    if (show) modal.classList.remove("hidden");
    if (!show) modal.classList.add("hidden");
  }

  document.querySelectorAll("#cancel_filter_modal").forEach(item => {
    item.addEventListener("click", function(e) {
      toggleFilterModal(false);
    });
  });

  document.getElementById("confirm_filter_modal").addEventListener("click", function(e) {
    e.preventDefault();
    var that = this;
    var blob = "";

    var xhr = new XMLHttpRequest();

    xhr.onload = function() {
      if (this.status == 200) {
        blob = new Blob([xhr.response], {
          type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        });

        var link = document.createElement('a');

        link.href = window.URL.createObjectURL(blob);
        link.download = `${that.dataset.reportname}.xls`;

        link.click();
        window.SpinLoad.hidden();
      } else {
        window.SpinLoad.hidden();
        toastr.error("{{ __('Não foi possível gerar o arquivo, devido a dados inconsistentes. ') }}");
      }
    };

    try {
        xhr.open('GET', that.href, true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.responseType = 'blob';

        window.SpinLoad.show();
        xhr.send();
    } catch (e) {
        alert(e);
    }

  });

  if (document.querySelector(".filter-reports")) {
    document.querySelectorAll(".filter-reports").forEach(item => {
      item.addEventListener("click", function(e) {
        e.preventDefault();
        toggleFilterModal(true);
        var confirm = document.querySelector("#filter_modal #confirm_filter_modal");
        confirm.href = this.href;
        confirm.dataset.root = this.href;
        confirm.dataset.reportname= this.innerHTML;
        setDate();
      });
    });
  }

  function setDate() {
    var startDate = document.querySelector("#start_date").value;
    var endDate = document.querySelector("#end_date").value;
    var confirm = document.querySelector("#filter_modal #confirm_filter_modal");
    confirm.href = confirm.dataset.root + `?start_date=${startDate}&end_date=${endDate}`;
  }

  document.querySelector("#start_date").addEventListener("change", function() {
    setDate();
  });

  document.querySelector("#end_date").addEventListener("change", function() {
    setDate();
  });
</script>

<x-spin-load />
