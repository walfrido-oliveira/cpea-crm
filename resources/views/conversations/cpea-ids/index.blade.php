<x-app-layout>
    <div class="py-6 index-conversationItems">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('IDCPEA') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-conversationItems" data-type="multiple">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="cpea_id">
                                {{ __('IDCPEA') }}
                            </label>
                            <x-jet-input id="cpea_id" class="form-control block w-full filter-field" type="text" name="cpea_id" :value="app('request')->input('cpea_id')" autofocus autocomplete="id" />
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="customer_name">
                                {{ __('Cliente') }}
                            </label>
                            <x-jet-input id="customer_name" class="form-control block w-full filter-field" type="text" name="customer_name" :value="app('request')->input('customer_name')" autofocus autocomplete="id" />
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="employee_id">
                                {{ __('Gestor') }}
                            </label>
                            <x-custom-select class="mt-1" :options="$employees" name="employee_id" id="employee_id" :value="app('request')->input('employee_id')"/>
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="direction_id">
                                {{ __('Diretoria') }}
                            </label>
                            <x-custom-select class="mt-1" :options="$directions" name="direction_id" id="direction_id" :value="app('request')->input('direction_id')"/>
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="department_id">
                                {{ __('Departamento') }}
                            </label>
                            <x-custom-select class="mt-1" :options="$departments" name="department_id" id="department_id" :value="app('request')->input('department_id')"/>
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="conversation_status_id">
                                {{ __('Status') }}
                            </label>
                            <x-custom-select class="mt-1" :options="$conversationStatuses" name="conversation_status_id" id="conversation_status_id" :value="app('request')->input('conversation_status_id')"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="conversation_items_table" class="table table-responsive md:table w-full">
                        @include('conversations.cpea-ids.filter-result', ['conversationItems' => $conversationItems, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                    {{ $conversationItems->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

     <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('customers.cpea-ids.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;

                var customer_name = document.getElementById("customer_name").value;
                var conversation_status_id = document.getElementById("conversation_status_id").value;
                var cpea_id = document.getElementById("cpea_id").value;
                var employee_id = document.getElementById("employee_id").value;
                var direction_id = document.getElementById("direction_id").value;
                var department_id = document.getElementById("department_id").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("conversation_items_table").innerHTML = resp.filter_result;
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

                if(customer_name) data.append('customer_name', customer_name);
                if(conversation_status_id) data.append('conversation_status_id', conversation_status_id);
                if(cpea_id) data.append('cpea_id', cpea_id);
                if(employee_id) data.append('employee_id', employee_id);
                if(direction_id) data.append('direction_id', direction_id);
                if(department_id) data.append('department_id', department_id);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('customers.cpea-ids.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;

                var customer_name = document.getElementById("customer_name").value;
                var conversation_status_id = document.getElementById("conversation_status_id").value;
                var cpea_id = document.getElementById("cpea_id").value;
                var employee_id = document.getElementById("employee_id").value;
                var direction_id = document.getElementById("direction_id").value;
                var department_id = document.getElementById("department_id").value;


                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("conversation_items_table").innerHTML = resp.filter_result;
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

                if(customer_name) data.append('customer_name', customer_name);
                if(conversation_status_id) data.append('conversation_status_id', conversation_status_id);
                if(cpea_id) data.append('cpea_id', cpea_id);
                if(employee_id) data.append('employee_id', employee_id);
                if(direction_id) data.append('direction_id', direction_id);
                if(department_id) data.append('department_id', department_id);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#conversation_items_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-conversationItems').forEach(item => {
                    item.addEventListener("click", function() {
                        if(this.dataset.type != 'multiple') {
                            var url = this.dataset.url;
                            var modal = document.getElementById("delete_customer_modal");
                            modal.dataset.url = url;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                        else {
                            var urls = '';
                            document.querySelectorAll('input:checked.conversationItems-url').forEach((item, index, arr) => {
                                urls += item.value ;
                                if(index < (arr.length - 1)) {
                                    urls += ',';
                                }
                            });

                            if(urls.length > 0) {
                                var modal = document.getElementById("delete_customer_modal");
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
