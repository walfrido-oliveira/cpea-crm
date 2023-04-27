<x-app-layout>
    <div class="py-6 edit-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('config.emails.store') }}">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Templates de E-mail') }}</h1>
                    </div>
                </div>

                <div class="px-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex">
                        <table class="table table-responsive md:table" id="table">
                            <thead>
                                <tr class="thead-light">
                                    <th class="sortable" data-index="0">{{ __('Assunto') }}</th>
                                    <th class="sortable" data-index="0">{{ __('Descrição') }}</th>
                                    <th>{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $key => $template)
                                    <tr>
                                        <td>{{ $template->subject }}</td>
                                        <td>{{ $template->description }}</td>
                                        <td>
                                            <a class="btn-transition-warning" href="{{ route('config.emails.templates.edit', ['template' => $template->id]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a class="btn-transition-primary" target="_blank" rel="noopener noreferrer" href="{{ route('config.emails.templates.mail-preview', ['template' => $template->id]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex mt-4 p-2" id="pagination">
                            {{ $templates->appends(request()->input())->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
