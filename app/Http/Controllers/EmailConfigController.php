<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest;
use Illuminate\Support\Facades\Redirect;

class EmailConfigController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the form for editing the EmailConfig.
     *
     * @param  @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mailFromName = Config::get('mail_from_name');
        $mailFromAdress = Config::get('mail_from_adress');
        $mailHost = Config::get('mail_host');
        $mailUserName = Config::get('mail_user_name');
        $mailPassword = Config::get('mail_password');
        $mailPort = Config::get('mail_port');
        $mailEncryption = Config::get('mail_encryption');
        $mailHeader = Config::get('mail_header');
        $mailFooter = Config::get('mail_footer');
        $mailCSS = Config::get('mail_css');
        $mailSignature = Config::get('mail_signature');

        $encryptionList = ["ssl" => "SSL", "tls" => "TLS", "none" => "Nenhuma"];

        return view('config.emails.index',
        compact('mailFromName', 'mailFromAdress', 'mailHost', 'mailUserName',
        'mailPassword', 'mailPort', 'mailEncryption', 'encryptionList', 'mailHeader',
        'mailFooter', 'mailCSS', 'mailSignature'));
    }

    /**
     * Update config in storage.
     *
     * @param  ConfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigRequest $request)
    {
        $data = $request->except('_method', '_token');

        foreach ($data as $key => $val) {
            Config::add($key, $val, Config::getDataType($key));
        }

        $notification = array(
            'message' => 'Configurações salvas com sucesso!',
            'alert-type' => 'success'
        );

        return Redirect::to(route('config.emails.index'))->with($notification);
    }
}
