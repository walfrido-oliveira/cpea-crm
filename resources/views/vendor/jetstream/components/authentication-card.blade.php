<div class="flex">
    <div class="min-h-screen md:w-1/2 w-full flex flex-col sm:justify-center items-center p-6 pb-0 sm:pt-0 bg-gray-100">
        <div class="top-0 my-4 flex">
            {{ $logo }}
        </div>

        <div class="w-full sm:max-w-md px-6 py-4 overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    <div class="min-h-screen md:flex hidden w-full">
        <img class="min-h-screen w-full" style="height: 1rem; min-height: 100%" src="{{ asset('img/login.jpg') }}" alt="Image">
    </div>
</div>
