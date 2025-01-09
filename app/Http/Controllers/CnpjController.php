<?php

namespace App\Http\Controllers;

use App\Models\Cnpj;
use Illuminate\Http\Request;

class CnpjController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin')->only(['create', 'edit', 'destroy', 'store', 'update']);
    $this->middleware('role:admin|viewer')->only(['index', 'show']);
  }

  public function validation($request)
  {
    $request->validate([
      'unit' => ['required', 'string', 'max:255'],
      'cnpj' => ['required', 'string', 'max:18', 'unique:cnpjs,cnpj,' . $request->cnpj],
      'corporate_name' => ['required', 'string', 'max:255'],
    ]);
  }

  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $cnpjs =  Cnpj::filter($request->all());
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'cnpj';

    return view('cnpjs.index', compact('cnpjs', 'ascending', 'orderBy'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('cnpjs.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validation($request);

    $input = $request->all();

    Cnpj::create([
      'unit' => $input['unit'],
      'cnpj' => preg_replace('/[^0-9]/', '', $input['cnpj']),
      'corporate_name' => $input['corporate_name'],
    ]);


    $resp = [
      'message' => __('Cnpj Cadastrado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('cnpjs.index')->with($resp);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $cnpj = Cnpj::findOrFail($id);
    return view('cnpjs.show', compact('cnpj'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $cnpj = Cnpj::findOrFail($id);
    return view('cnpjs.edit', compact('cnpj'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $cnpj = Cnpj::findOrFail($id);

    $this->validation($request);

    $input = $request->all();

    $cnpj->update([
      'unit' => $input['unit'],
      'cnpj' => preg_replace('/[^0-9]/', '', $input['cnpj']),
      'corporate_name' => $input['corporate_name'],
    ]);

    $resp = [
      'message' => __('CNPJ Atualizado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('cnpjs.index')->with($resp);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $cnpj = Cnpj::findOrFail($id);

    $cnpj->delete();

    return response()->json([
      'message' => __('CNPJ Apagado com Sucesso!!'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Filter cnpj
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $cnpjs = Cnpj::filter($request->all());
    $cnpjs = $cnpjs->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('cnpjs.filter-result', compact('cnpjs', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $cnpjs,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
