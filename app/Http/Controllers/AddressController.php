<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
  public function cep($cep)
  {
    $results = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=$cep");
    return response()->json($results);
  }

  public function cities($state)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$state/distritos?orderBy=nome");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);


    curl_close($ch);

    return response()->json(json_decode($response, true));
  }
}
