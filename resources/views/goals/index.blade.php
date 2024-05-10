<x-app-layout>
  <div class="py-6 index-goals">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

      <div class="flex md:flex-row flex-col">
        <div class="w-full flex items-center">
          <h1>{{ __('Meta') }}</h1>
        </div>
        <div class="w-full flex justify-end">
          <div class="m-2 ">
            <a class="btn-outline-info" href="{{ route('config.goals.create') }}">{{ __('Cadastrar') }}</a>
          </div>
          <div class="m-2">
            <button type="button" class="btn-outline-danger delete-goals" data-type="multiple">{{ __('Apagar')
              }}</button>
          </div>
        </div>
      </div>

      <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
        <div class="filter-container">
          <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
            <div class="w-full md:w-1/5 px-2 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="year">
                  {{ __('Ano') }}
              </label>
              <x-jet-input id="year" class="form-control block w-full filter-field" type="text" name="year" :value="app('request')->input('year')" autofocus autocomplete="year" />
            </div>
            <div class="w-full md:w-1/5 px-2 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="month">
                {{ __('Mês') }}
              </label>
              <x-custom-select :options="months()" name="month" id="month" :value="app('request')->input('month')" />
            </div>
            <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="direction_id">
                {{ __('Diretoria') }}
              </label>
              <x-custom-select :options="$directions" name="direction_id" id="direction_id" :value="app('request')->input('direction_id')" />
            </div>
            <div class="w-full md:w-1/3 px-2 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="department_id">
                {{ __('Departamento') }}
              </label>
              <x-custom-select :options="$departments" name="department_id" id="department_id" :value="app('request')->input('department_id')" />
            </div>
          </div>
        </div>
        <div class="flex mt-4">
          <table id="etapas_table" class="table table-responsive md:table w-full">
            @include('goals.filter-result', ['goals' => $goals, 'ascending' => $ascending, 'orderBy' => $orderBy])
          </table>
        </div>
        <div class="flex mt-4 p-2" id="pagination">
          {{ $goals->appends(request()->input())->links() }}
        </div>
      </div>
    </div>
  </div>

  <x-modal title="{{ __('Excluir Etapa') }}" msg="{{ __('Deseja realmente apagar esse Etapa?') }}"
    confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_etapa_modal" method="DELETE"
    redirect-url="{{ route('config.goals.index') }}" />

  <script>
    window.addEventListener("load", function() {
      var filterCallback = function (event) {
        var ajax = new XMLHttpRequest();
        var url = "{!! route('config.goals.filter') !!}";
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = 'POST';
        var paginationPerPage = document.getElementById("paginate_per_page").value;
        var department_id = document.getElementById("department_id").value;
        var direction_id = document.getElementById("direction_id").value;
        var year = document.getElementById("year").value;
        var month = document.getElementById("month").value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var resp = JSON.parse(ajax.response);
            document.getElementById("etapas_table").innerHTML = resp.filter_result;
            document.getElementById("pagination").innerHTML = resp.pagination;
            eventsFilterCallback();
            eventsDeleteCallback();
          } else if(this.readyState == 4 && this.status != 200) {
            toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
            eventsFilterCallback();
            eventsDeleteCallback();
          }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('paginate_per_page', paginationPerPage);
        data.append('ascending', ascending);
        data.append('order_by', orderBY);
        if(department_id) data.append('department_id', department_id);
        if(direction_id) data.append('direction_id', direction_id);
        if(year) data.append('year', year);
        if(month) data.append('month', month);

        ajax.send(data);
      }

      var ascending = "{!! $ascending !!}";
      var orderBY = "{!! $orderBy !!}";

      var orderByCallback = function (event) {
        orderBY = this.dataset.name;
        ascending = this.dataset.ascending;
        var that = this;
        var ajax = new XMLHttpRequest();
        var url = "{!! route('config.goals.filter') !!}";
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = 'POST';
        var paginationPerPage = document.getElementById("paginate_per_page").value;
        var department_id = document.getElementById("department_id").value;
        var direction_id = document.getElementById("direction_id").value;
        var year = document.getElementById("year").value;
        var month = document.getElementById("month").value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var resp = JSON.parse(ajax.response);
            document.getElementById("etapas_table").innerHTML = resp.filter_result;
            document.getElementById("pagination").innerHTML = resp.pagination;
            that.dataset.ascending = that.dataset.ascending == 'asc' ? that.dataset.ascending = 'desc' : that.dataset.ascending = 'asc';
            eventsFilterCallback();
            eventsDeleteCallback();
          } else if(this.readyState == 4 && this.status != 200) {
            toastr.error("{!! __('Um erro ocorreu ao gerar a consulta') !!}");
            eventsFilterCallback();
            eventsDeleteCallback();
          }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('paginate_per_page', paginationPerPage);
        data.append('ascending', ascending);
        data.append('order_by', orderBY);
        if(department_id) data.append('department_id', department_id);
        if(direction_id) data.append('direction_id', direction_id);
        if(year) data.append('year', year);
        if(month) data.append('month', month);

        ajax.send(data);
      }

      function eventsFilterCallback() {
        document.querySelectorAll('.filter-field').forEach(item => {
          item.addEventListener('change', filterCallback, false);
          item.addEventListener('keyup', filterCallback, false);
        });
        document.querySelectorAll("#etapas_table thead [data-name]").forEach(item => {
          item.addEventListener("click", orderByCallback, false);
        });
      }

      function eventsDeleteCallback() {
        document.querySelectorAll('.delete-goals').forEach(item => {
          item.addEventListener("click", function() {
            if(this.dataset.type != 'multiple') {
                var url = this.dataset.url;
                var modal = document.getElementById("delete_etapa_modal");
                modal.dataset.url = url;
                modal.classList.remove("hidden");
                modal.classList.add("block");
            }
            else {
              var urls = '';
              document.querySelectorAll('input:checked.goals-url').forEach((item, index, arr) => {
                urls += item.value ;
                if(index < (arr.length - 1)) {
                  urls += ',';
                }
              });

              if(urls.length > 0) {
                var modal = document.getElementById("delete_etapa_modal");
                modal.dataset.url = urls;
                modal.classList.remove("hidden");
                modal.classList.add("block");
              }
            }
          });
        });
      }

      eventsDeleteCallback();
      eventsFilterCallback();
    });
  </script>

</x-app-layout>
