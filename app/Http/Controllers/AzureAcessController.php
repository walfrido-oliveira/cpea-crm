<?php

namespace App\Http\Controllers;

use App\Models\Azure;

class AzureAcessController extends Controller
{
    public function token()
    {
      return Azure::token();
    }

    public function getUserId($email)
    {
      return Azure::user($email);
    }


}
