<x-app-layout>
    <div class="py-6 edit-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('config.emails.store') }}">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Configurações de E-mail') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('users.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Nome do Remetente')" for="mail_from_name" required/>
                            <x-jet-input id="mail_from_name" class="form-control block w-full" type="text" name="mail_from_name" maxlength="255" :value="$mailFromName" required autofocus autocomplete="mail_from_name" placeholder="{{ __('Nome do remetente') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('E-mail')" for="mail_from_adress" required/>
                            <x-jet-input id="mail_from_adress" class="form-control block w-full" type="text" name="mail_from_adress" maxlength="255" :value="$mailFromAdress" required autofocus autocomplete="mail_from_adress" placeholder="{{ __('E-mail') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Host')" for="mail_host" required/>
                            <x-jet-input id="mail_host" class="form-control block w-full" type="text" name="mail_host" maxlength="255" :value="$mailHost" required autofocus autocomplete="mail_host" placeholder="{{ __('SMTP do Servidor') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Porta')" for="mail_port" required/>
                            <x-jet-input id="mail_port" class="form-control block w-full" type="text" name="mail_port" maxlength="255" :value="$mailPort" required autofocus autocomplete="mail_port" placeholder="{{ __('Porta do E-mail') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Usuário')" for="mail_user_name" required/>
                            <x-jet-input id="mail_user_name" class="form-control block w-full" type="text" name="mail_user_name" maxlength="255" :value="$mailUserName" required autofocus autocomplete="mail_user_name" placeholder="{{ __('Usuário do SMTP') }}"/>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Senha')" for="mail_password" required/>
                            <x-jet-input id="mail_password" class="form-control block w-full" type="text" name="mail_password" maxlength="255" :value="$mailPassword" required autofocus autocomplete="mail_password" placeholder="{{ __('Senha do E-mail') }}"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Encriptação')" for="mail_encryption" required/>
                            <x-custom-select :options="$encryptionList" name="mail_encryption" id="mail_encryption" :value="$mailEncryption" required/>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Assinatura do Email Padrão')" for="mail_signature" required/>
                            <textarea class="form-input w-full" name="mail_signature" id="mail_signature" cols="30" rows="3" required >{{ $mailSignature }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Códico CSS do Email')" for="mail_css" required/>
                            <textarea class="form-input w-full" name="mail_css" id="mail_header" cols="30" rows="10" required >{{ $mailCSS }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Conteúdo do Cabeçalho do Email do Cliente (HTML)')" for="mail_header" required/>
                            <textarea class="form-input w-full" name="mail_header" id="mail_header" cols="30" rows="10" required >{{ $mailHeader }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Conteúdo do Rodapé do Email do Cliente (HTML)')" for="mail_footer" required/>
                            <textarea class="form-input w-full" name="mail_footer" id="mail_footer" cols="30" rows="10" required >{{ $mailFooter }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
