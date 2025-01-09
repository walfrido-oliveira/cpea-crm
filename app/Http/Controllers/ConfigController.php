<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest;
use Illuminate\Support\Facades\Redirect;

class ConfigController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin');
  }

  /**
   * Show the form for editing the Config.
   *
   * @param  @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $sessionLifeTime = Config::get('session_lifetime');
    $newCustomerMonths = Config::get('new_customer_months');

    return view('config.index', compact('sessionLifeTime', 'newCustomerMonths'));
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

    return Redirect::to(route('config.index'))->with($notification);
  }
}
