<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EtapaController extends Controller
{
  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $etapas =  Etapa::filter($request->all());
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

    return view('etapas.index', compact('etapas', 'ascending', 'orderBy'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('etapas.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('etapas', 'name')],
    ]);

    $input = $request->all();

    Etapa::create([
      'name' => $input['name'],
    ]);

    $resp = [
      'message' => __('Etapa Cadastrado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('etapas.index')->with($resp);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $etapa = Etapa::findOrFail($id);
    return view('etapas.show', compact('etapa'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $etapa = Etapa::findOrFail($id);
    return view('etapas.edit', compact('etapa'));
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
    $etapa = Etapa::findOrFail($id);

    $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('etapas', 'name')->ignore($etapa->id)],
    ]);

    $input = $request->all();

    $etapa->update([
      'name' => $input['name'],
    ]);

    $resp = [
      'message' => __('Etapa Atualizado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('etapas.index')->with($resp);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $etapa = Etapa::findOrFail($id);

    $etapa->delete();

    return response()->json([
      'message' => __('Etapa Apagado com Sucesso!!'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Filter etapa
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $etapas = Etapa::filter($request->all());
    $etapas = $etapas->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('etapas.filter-result', compact('etapas', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $etapas,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
