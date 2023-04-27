<div x-data="{ open: false }">
    <div class="flex">
        <button @click="open = !open" id="nav-toggle" class="w-full block btn-transition-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        </button>
    </div>
    <!--Search-->
    <div :class="{'block': open, 'hidden': !open}" class="w-full block" id="search-content">
        <div class="container mx-auto">
            <input id="q" name="q" type="search" placeholder="Buscar..." autofocus="autofocus" class="filter-field w-full form-control no-border mt-4">
        </div>
    </div>
</div>
