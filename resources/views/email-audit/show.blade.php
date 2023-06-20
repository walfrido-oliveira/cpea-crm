<x-app-layout>
    <div class="py-6 show-email-audit">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <div class="flex md:flex-row flex-col">
                <div class="w-full flex items-center">
                    <h1>{{ __('Detalhes do Diretoria') }}</h1>
                </div>
                <div class="w-full flex justify-end">
                    <div class="m-2 ">
                        <a class="btn-outline-info" href="{{ route('config.emails.email-audit.index') }}">{{ __('Listar') }}</a>
                    </div>
                </div>
            </div>

            <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                <div class="mx-4 px-3 py-2 mt-4">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('ID') }}</p>
                        </div>

                        <div class="w-full md:w-1/2">
                            <p class=   "text-gray-500 font-bold">{{ $emailAudit->id }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Assunto') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $emailAudit->subject }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Para') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            @foreach ($emailAudit->to as $to)
                                <p class="text-gray-500 font-bold">{{ $to }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Corpo do email') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">
                                <a href="{{ route("config.emails.email-audit.body", ["email_audit" => $emailAudit->id]) }}" target="_black">
                                    Viusalizar e-mail
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-2/12">
                            <p class="font-bold">{{ __('Data de Envio') }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <p class="text-gray-500 font-bold">{{ $emailAudit->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
