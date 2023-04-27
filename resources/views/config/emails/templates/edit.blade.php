<x-app-layout>
    <div class="py-6 edit-template">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('config.emails.templates.update', ['template' => $template->id]) }}">
                @csrf
                @method("PUT")
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Editar Template') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('config.emails.templates.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Assunto')" for="subject" required/>
                            <x-jet-input id="subject" class="form-control block w-full" type="text" name="subject" maxlength="255" :value="$template->subject" required autofocus autocomplete="subject"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Descrição')" for="description" required/>
                            <x-jet-input id="description" class="form-control block w-full" type="text" name="description" maxlength="255" :value="$template->description" required autofocus autocomplete="description"/>
                        </div>
                    </div>

                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Corpo do E-mail')" for="value" required/>
                            <textarea class="form-input w-full" name="value" id="value" cols="30" rows="10" required >{{ $template->value }}</textarea>
                            <div class="mt-4">
                                <p class="m-0 text-gray-900">{{ __('Você pode utilizar as seguintes tags:') }}</p>
                                @foreach ($tags as $tag)
                                        <small class="tag inlie text-sm text-gray-500 cursor-pointer">{{ $tag }} </small>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
