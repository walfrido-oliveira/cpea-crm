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
        $results = file_get_contents("https://servicodados.ibge.gov.br/api/v1/localidades/estados/$state/distritos?orderBy=nome");
        return response()->json(json_decode($results));
    }
}
