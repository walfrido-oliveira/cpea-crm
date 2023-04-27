<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sectors =  Sector::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('sectors.index', compact('sectors', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sectors.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('sectors', 'name')],
        ]);

        $input = $request->all();

       Sector::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Setor Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('sectors.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sector = Sector::findOrFail($id);
        return view('sectors.show', compact('sector'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Sector::findOrFail($id);
        return view('sectors.edit', compact('sector'));
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
        $sector = Sector::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sectors', 'name')->ignore($sector->id)],
        ]);

        $input = $request->all();

        $sector->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Setor Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('sectors.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);

        $sector->delete();

        return response()->json([
            'message' => __('Setor Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter sector
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $sectors = Sector::filter($request->all());
        $sectors = $sectors->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('sectors.filter-result', compact('sectors', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $sectors,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
