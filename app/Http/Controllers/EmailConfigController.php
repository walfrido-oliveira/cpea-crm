<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest;
use App\Models\Department;
use App\Models\Direction;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class EmailConfigController extends Controller
{

  public function __construct()
  {
    $this->middleware('role:admin');
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
    $mailConversationApprovedUsersTemp = unserialize(Config::get('mail_conversation_approved_users'));
    $mailConversationApprovedDepartmentsTemp = unserialize(Config::get('mail_conversation_approved_departments'));
    $mailConversationApprovedDirectionsTemp = unserialize(Config::get('mail_conversation_approved_directions'));

    $mailConversationApprovedUsers = is_array($mailConversationApprovedUsersTemp) ? User::whereIn("id", $mailConversationApprovedUsersTemp)->get()->pluck("full_name", "id")->toArray() : [];
    $mailConversationApprovedDepartments = is_array($mailConversationApprovedDepartmentsTemp) ? Department::whereIn("id", $mailConversationApprovedDepartmentsTemp)->get()->pluck("name", "id")->toArray() : [];
    $mailConversationApprovedDirections = is_array($mailConversationApprovedDirectionsTemp) ? Direction::whereIn("id", $mailConversationApprovedDirectionsTemp)->get()->pluck("name", "id")->toArray() : [];

    $users = User::all()->pluck("full_name", "id");
    $departments = Department::pluck("name", "id");
    $directions = Direction::pluck("name", "id");

    $encryptionList = ["ssl" => "SSL", "tls" => "TLS", "none" => "Nenhuma"];

    return view(
      'config.emails.index',
      compact(
        'mailFromName',
        'mailFromAdress',
        'mailHost',
        'mailUserName',
        'mailPassword',
        'mailPort',
        'mailEncryption',
        'encryptionList',
        'mailHeader',
        'mailFooter',
        'mailCSS',
        'mailSignature',
        'users',
        'departments',
        'directions',
        'mailConversationApprovedUsers',
        'mailConversationApprovedDepartments',
        'mailConversationApprovedDirections'
      )
    );
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
      if (!is_array($val)) Config::add($key, $val, Config::getDataType($key));
      if (is_array($val)) Config::add($key, serialize($val), Config::getDataType($key));
    }

    $notification = array(
      'message' => 'Configurações salvas com sucesso!',
      'alert-type' => 'success'
    );

    return Redirect::to(route('config.emails.index'))->with($notification);
  }
}
