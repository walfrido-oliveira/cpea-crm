<div class="md:flex flex-col md:flex-row sidebar md:min-h-screen">
    <div @click.away="open = false"
        class="flex flex-col w-full md:w-72 text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0"
        x-data="{ open: false }">
        <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between h-10">
            <a href="#"
                class="text-lg font-semibold tracking-widest text-white uppercase rounded-lg focus:outline-none focus:shadow-outline"></a>
            <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path x-show="!open" fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                    <path x-show="open" fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <nav :class="{ 'block': open, 'hidden': !open }"
            class="flex-grow md:block px-0 pb-4 md:pb-0 md:overflow-y-auto">

            <a class="@if (request()->routeIs('users.index')) {{ 'active' }} @endif" href="{{ route('users.index') }}?status=active">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Usuários
            </a>

            <a class="@if (request()->routeIs('employees.index')) {{ 'active' }} @endif"
                href="{{ route('employees.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Colaboradores
            </a>

            <div class="relative" x-data="{ customer: {{ request()->routeIs('customers.*') ? 'true' : 'false' }} }">
                <button @click="customer = !customer" class="submenu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Clientes</span>
                    <svg fill="currentColor" viewBox="0 0 20 20"
                        :class="{ 'rotate-180': customer, 'rotate-0': !customer }"
                        class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="customer" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="relative right-0 w-full origin-top-right">
                    <a class="@if (request()->routeIs('customers.index')) {{ 'active' }} @endif" href="{{ route('customers.index') }}">
                        Clientes
                    </a>
                    <a class="@if (request()->routeIs('customers.companies.index')) {{ 'active' }} @endif" href="{{ route('customers.companies.index') }}">
                        Empresas/Filiais
                    </a>
                    <a class="@if (request()->routeIs('customers.cpea-ids.index')) {{ 'active' }} @endif" href="{{ route('customers.cpea-ids.index') }}">
                        IDCPEA
                    </a>
                </div>
            </div>

            <div class="relative" x-data="{ openConfig: {{ request()->routeIs('config.emails.*') ? 'true' : 'false' }} }">
                <button @click="openConfig = !openConfig" class="submenu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Cadastros</span>
                    <svg fill="currentColor" viewBox="0 0 20 20"
                        :class="{ 'rotate-180': openConfig, 'rotate-0': !openConfig }"
                        class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="openConfig" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="relative right-0 w-full origin-top-right">
                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('occupations.index')) {{ 'active' }} @endif"
                            href="{{ route('occupations.index') }}">
                            Cargos
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('departments.index')) {{ 'active' }} @endif"
                            href="{{ route('departments.index') }}">
                            Departamentos
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('directions.index')) {{ 'active' }} @endif"
                            href="{{ route('directions.index') }}">
                            Diretorias
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('general-contact-types.index')) {{ 'active' }} @endif"
                            href="{{ route('general-contact-types.index') }}">
                            Tipo Contato
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('segments.index')) {{ 'active' }} @endif"
                            href="{{ route('segments.index') }}">
                            Segmentos
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('conversation-statuss.index')) {{ 'active' }} @endif"
                            href="{{ route('conversation-statuss.index') }}">
                            Status de Interação
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('products.index')) {{ 'active' }} @endif"
                            href="{{ route('products.index') }}">
                            Produtos
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('etapas.index')) {{ 'active' }} @endif"
                            href="{{ route('etapas.index') }}">
                            Etapas
                        </a>
                    </div>

                    <div class="px-0 py-0">
                        <a class="@if (request()->routeIs('cnpjs.index')) {{ 'active' }} @endif"
                            href="{{ route('cnpjs.index') }}">
                            CNPJ CPEA
                        </a>
                    </div>

                </div>
            </div>

            <a class="@if (request()->routeIs('config.index')) {{ 'active' }} @endif"
                href="{{ route('config.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6 inline">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Configurações
            </a>

            <div class="relative" x-data="{ openConfig: {{ request()->routeIs('config.emails.*') ? 'true' : 'false' }} }">
                <button @click="openConfig = !openConfig" class="submenu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <span>E-mail</span>
                    <svg fill="currentColor" viewBox="0 0 20 20"
                        :class="{ 'rotate-180': openConfig, 'rotate-0': !openConfig }"
                        class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="openConfig" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="relative right-0 w-full origin-top-right">
                    <div class="px-0 py-0 ">
                        <a class="@if (request()->routeIs('config.emails.index')) {{ 'active' }} @endif"
                            href="{{ route('config.emails.index') }}">Configurações</a>
                    </div>
                    <div class="px-0 py-0 ">
                        <a class="@if (request()->routeIs('config.emails.templates.index')) {{ 'active' }} @endif"
                            href="{{ route('config.emails.templates.index') }}">Templates</a>
                    </div>
                    <div class="px-0 py-0 ">
                        <a class="@if (request()->routeIs('config.emails.email-audit.index')) {{ 'active' }} @endif"
                            href="{{ route('config.emails.email-audit.index') }}">Email enviados</a>
                    </div>
                </div>
            </div>


        </nav>
    </div>
</div>
