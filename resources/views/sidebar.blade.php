<div class="md:flex flex-col md:flex-row sidebar md:min-h-screen">
  <div @click.away="open = false"
    class="flex flex-col w-full md:w-72 text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0"
    x-data="{ open: false }">
    <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between h-10">
      <a href="#" class="text-lg font-semibold tracking-widest text-white uppercase rounded-lg focus:outline-none focus:shadow-outline"></a>
      <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
        <x-icon.hamburger/>
      </button>
    </div>
    <nav :class="{ 'block': open, 'hidden': !open }" class="flex-grow md:block px-0 pb-4 md:pb-0 md:overflow-y-auto">

      <a class="@if (request()->routeIs('users.index')) {{ 'active' }} @endif" href="{{ route('users.index') }}?status=active">
        <x-icon.user/>
        Usuários
      </a>

      <a class="@if (request()->routeIs('employees.index')) {{ 'active' }} @endif" href="{{ route('employees.index') }}">
        <x-icon.user/>
        Colaboradores
      </a>

      <div class="relative" x-data="{ customer: {{ request()->routeIs('customers.*') ? 'true' : 'false' }} }">
        <button @click="customer = !customer" class="submenu">
          <x-icon.user/>
          <span>Clientes</span>
          <x-icon.arrow-down name="customer"/>
        </button>
        <div x-show="customer" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
          <a class="@if (request()->routeIs('customers.index')) {{ 'active' }} @endif" href="{{ route('customers.index') }}">Clientes</a>
          <a class="@if (request()->routeIs('customers.companies.index')) {{ 'active' }} @endif" href="{{ route('customers.companies.index') }}">Empresas/Filiais</a>
          <a class="@if (request()->routeIs('customers.cpea-ids.index')) {{ 'active' }} @endif" href="{{ route('customers.cpea-ids.index') }}">IDCPEA</a>
        </div>
      </div>

      <div class="relative" x-data="{ openConfig: false }">
        <button @click="openConfig = !openConfig" class="submenu">
          <x-icon.plus/>
          <span>Cadastros</span>
          <x-icon.arrow-down name="openConfig"/>
        </button>
        <div x-show="openConfig" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('occupations.index')) {{ 'active' }} @endif" href="{{ route('occupations.index') }}">Cargos</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('departments.index')) {{ 'active' }} @endif" href="{{ route('departments.index') }}">Departamentos</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('directions.index')) {{ 'active' }} @endif" href="{{ route('directions.index') }}">Diretorias</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('general-contact-types.index')) {{ 'active' }} @endif" href="{{ route('general-contact-types.index') }}">Tipo Contato</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('segments.index')) {{ 'active' }} @endif" href="{{ route('segments.index') }}">Segmentos</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('conversation-statuss.index')) {{ 'active' }} @endif" href="{{ route('conversation-statuss.index') }}">Status de Interação</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('products.index')) {{ 'active' }} @endif" href="{{ route('products.index') }}">Produtos</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('etapas.index')) {{ 'active' }} @endif" href="{{ route('etapas.index') }}">Etapas</a>
          </div>

          <div class="px-0 py-0">
            <a class="@if (request()->routeIs('cnpjs.index')) {{ 'active' }} @endif" href="{{ route('cnpjs.index') }}">CNPJ CPEA</a>
          </div>

        </div>
      </div>

      <div class="relative" x-data="{ openConfig: {{ request()->routeIs('config.*') ? 'true' : 'false' }} }">
        <button @click="openConfig = !openConfig" class="submenu">
          <x-icon.tools/>
          <span>Configurações</span>
          <x-icon.arrow-down name="openConfig"/>
        </button>
        <div x-show="openConfig" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
          <div class="px-0 py-0 ">
            <a class="@if (request()->routeIs('config.index')) {{ 'active' }} @endif" href="{{ route('config.index') }}">Configurações Gerais</a>
          </div>
          <div class="px-0 py-0 ">
            <a class="@if (request()->routeIs('config.goals.index')) {{ 'active' }} @endif" href="{{ route('config.goals.index') }}">Metas</a>
          </div>
          <div class="px-0 py-0 ">
            <a class="@if (request()->routeIs('config.emails.index')) {{ 'active' }} @endif" href="{{ route('config.emails.index') }}">Emails</a>
          </div>
          <div class="px-0 py-0 ">
            <a class="@if (request()->routeIs('config.emails.templates.index')) {{ 'active' }} @endif" href="{{ route('config.emails.templates.index') }}">Templates de Email</a>
          </div>
          <div class="px-0 py-0 ">
            <a class="@if (request()->routeIs('config.emails.email-audit.index')) {{ 'active' }} @endif" href="{{ route('config.emails.email-audit.index') }}">Email enviados</a>
          </div>
        </div>
      </div>

      <div class="relative" x-data="{ reports: {{ request()->routeIs('reports.*') ? 'true' : 'false' }} }">
        <button @click="reports = !reports" class="submenu">
          <x-icon.list-bullet/>
          <span>Relatórios</span>
          <x-icon.arrow-down name="reports"/>
        </button>
        <div x-show="reports" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="transform opacity-0 scale-95"
          x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
          x-transition:leave-start="transform opacity-100 scale-100"
          x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
          <div class="px-0 py-0 ">
            <a  href="{{ route('reports.report-1') }}" class="filter-reports">Interações</a>
          </div>
          <div class="px-0 py-0 ">
            <a  href="{{ route('reports.report-2') }}" class="filter-reports">Clientes/Empresas</a>
          </div>
          <div class="px-0 py-0 ">
            <a href="{{ route('reports.report-3') }}" class="filter-reports">Contatos Gerais</a>
          </div>
          <div class="px-0 py-0 ">
            <a href="{{ route('reports.report-4') }}" class="filter-reports">Contatos</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</div>
