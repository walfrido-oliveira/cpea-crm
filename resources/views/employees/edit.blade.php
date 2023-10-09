<x-app-layout>
    <div class="py-6 edit-employees">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Colaborador') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('employees.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-row flex-col">
                    <x-jet-validation-errors class="mb-4" />
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="registration" value="{{ __('Matrícula') }}" required/>
                            <x-jet-input id="registration" class="form-control block mt-1 w-full" type="text" :value="$employee->registration" name="registration" maxlength="255" required autofocus autocomplete="registration" placeholder="{{ __('Matrícula') }}"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="name" value="{{ __('Nome Completo') }}" required/>
                            <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" placeholder="{{ __('Nome Completo') }}" :value="$employee->name"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="user_id" value="{{ __('Usuário') }}" />
                            <x-custom-select :options="$users" value="{{ $employee->user_id }}" name="user_id" id="user_id" class="mt-1"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="manager_id" value="{{ __('Gestor Imediato') }}" />
                            <x-custom-select :options="$employees" name="manager_id" id="manager_id" :value="$employee->manager_id"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label for="occupation_id" value="{{ __('Cargo') }}" required/>
                            <x-custom-select :options="$occupations" name="occupation_id" id="occupation_id" required :value="$employee->occupation_id"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="direction_id" value="{{ __('Diretoria') }}" required/>
                            <x-custom-select :options="$directions" name="direction_id" id="direction_id" required :value="$employee->direction_id"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="department_id" value="{{ __('Departamento') }}" required/>
                            <x-custom-select :options="$departments" name="department_id" id="department_id" required :value="$employee->department_id"/>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <x-jet-label for="status" value="{{ __('Situação do Colaborador') }}" required/>
                            <x-custom-select class="mt-1" :options="$status" name="status" id="status" :value="$employee->status" required/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="project_manager" class="flex items-center">
                                <input id="project_manager" type="checkbox" class="form-checkbox" name="project_manager" value="true" @if($employee->project_manager) checked @endif>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Gestor de Projeto?') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    </div>

    <x-spin-load />

</x-app-layout>
