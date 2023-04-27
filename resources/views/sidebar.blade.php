

<div class="md:flex flex-col md:flex-row sidebar md:min-h-screen">
    <div @click.away="open = false" class="flex flex-col w-full md:w-72 text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0" x-data="{ open: false }">
      <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between h-10">
        <a href="#" class="text-lg font-semibold tracking-widest text-white uppercase rounded-lg focus:outline-none focus:shadow-outline"></a>
        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
          <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-0 pb-4 md:pb-0 md:overflow-y-auto">

        <a class="@if(request()->routeIs('users.index')) {{ 'active' }} @endif" href="{{ route('users.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Usuários
        </a>

        <div class="relative" x-data="{ openConfig: {{ request()->routeIs('config.emails.*') ? 'true' : 'false' }} }">
          <button @click="openConfig = !openConfig" class="submenu">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
            </svg>
            <span>E-mail</span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': openConfig, 'rotate-0': !openConfig}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
          <div x-show="openConfig" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
            <div class="px-0 py-0 ">
                <a class="@if(request()->routeIs('config.emails.index')) {{ 'active' }} @endif" href="{{ route('config.emails.index') }}">Configurações</a>
            </div>
            <div class="px-0 py-0 ">
                <a class="@if(request()->routeIs('config.emails.templates.index')) {{ 'active' }} @endif" href="{{ route('config.emails.templates.index') }}">Templates</a>
            </div>
          </div>
        </div>


      </nav>
    </div>
  </div>
