<x-app-layout>
    <div class="py-6 index-conversation-status">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">

            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Status da Interação') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('conversation-statuss.create') }}" >{{ __('Cadastrar') }}</a>
                    </div>
                    <div class="m-2">
                        <button type="button" class="btn-outline-danger delete-conversation-statuss" data-type="multiple">{{ __('Apagar') }}</button>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="filter-container">
                    <div class="flex -mx-3 mb-6 p-3 md:flex-row flex-col w-full">
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                {{ __('Status da Interação') }}
                            </label>
                            <x-jet-input id="name" class="form-control block w-full filter-field" type="text" name="name" :value="app('request')->input('name')" autofocus autocomplete="name" />
                        </div>
                        <div class="w-full md:w-1/2 px-2 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="type">
                                {{ __('Tipo de Interação') }}
                            </label>
                            <x-custom-select :options="$types" value="{{ app('request')->input('type') }}" name="type" id="type" class="mt-1"/>
                        </div>
                    </div>
                </div>
                <div class="flex mt-4">
                    <table id="conversation_status_table" class="table table-responsive md:table w-full">
                        @include('conversation-statuss.filter-result', ['conversationStatuss' => $conversationStatuss, 'ascending' => $ascending, 'orderBy' => $orderBy])
                    </table>
                </div>
                <div class="flex mt-4 p-2" id="pagination">
                        {{ $conversationStatuss->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal title="{{ __('Excluir Status da Interação') }}"
             msg="{{ __('Deseja realmente apagar esse Status da Interação?') }}"
             confirm="{{ __('Sim') }}" cancel="{{ __('Não') }}" id="delete_department_modal"
             method="DELETE"
             redirect-url="{{ route('conversation-statuss.index') }}"/>

    <script>
        window.addEventListener("load", function() {
            var filterCallback = function (event) {
                var ajax = new XMLHttpRequest();
                var url = "{!! route('conversation-statuss.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var name = document.getElementById("name").value;
                var type = document.getElementById("type").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("conversation_status_table").innerHTML = resp.filter_result;
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
                if(name) data.append('name', name);
                if(type) data.append('type', type);

                ajax.send(data);
            }

            var ascending = "{!! $ascending !!}";
            var orderBY = "{!! $orderBy !!}";

            var orderByCallback = function (event) {
                orderBY = this.dataset.name;
                ascending = this.dataset.ascending;
                var that = this;
                var ajax = new XMLHttpRequest();
                var url = "{!! route('conversation-statuss.filter') !!}";
                var token = document.querySelector('meta[name="csrf-token"]').content;
                var method = 'POST';
                var paginationPerPage = document.getElementById("paginate_per_page").value;
                var type = documcent.getElementById("type").value;
                var name = document.getElementById("name").value;

                ajax.open(method, url);

                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var resp = JSON.parse(ajax.response);
                        document.getElementById("conversation_status_table").innerHTML = resp.filter_result;
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
                if(type) data.append('type', type);
                if(name) data.append('name', name);

                ajax.send(data);
            }

            function eventsFilterCallback() {
                document.querySelectorAll('.filter-field').forEach(item => {
                    item.addEventListener('change', filterCallback, false);
                    item.addEventListener('keyup', filterCallback, false);
                });
                document.querySelectorAll("#conversation_status_table thead [data-name]").forEach(item => {
                    item.addEventListener("click", orderByCallback, false);
                });
            }

            function eventsDeleteCallback() {
                document.querySelectorAll('.delete-conversation-statuss').forEach(item => {
                item.addEventListener("click", function() {
                    if(this.dataset.type != 'multiple') {
                        var url = this.dataset.url;
                        var modal = document.getElementById("delete_department_modal");
                        modal.dataset.url = url;
                        modal.classList.remove("hidden");
                        modal.classList.add("block");
                    }
                    else {
                        var urls = '';
                        document.querySelectorAll('input:checked.conversation-statuss-url').forEach((item, index, arr) => {
                            urls += item.value ;
                            if(index < (arr.length - 1)) {
                                urls += ',';
                            }
                        });

                        if(urls.length > 0) {
                            var modal = document.getElementById("delete_department_modal");
                            modal.dataset.url = urls;
                            modal.classList.remove("hidden");
                            modal.classList.add("block");
                        }
                    }
                })
            });
            }

            eventsDeleteCallback();
            eventsFilterCallback();
        });
    </script>

</x-app-layout>
