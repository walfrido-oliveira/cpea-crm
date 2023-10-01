<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Direction;

class DirectionController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $directions =  Direction::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('directions.index', compact('directions', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directions.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('directions', 'name')],
            'acronym' => ['required', 'string'],
        ]);

        $input = $request->all();

       Direction::create([
            'name' => $input['name'],
            'acronym' => $input['acronym'],
        ]);

        $resp = [
            'message' => __('Diretoria Cadastrada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('directions.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $direction = Direction::findOrFail($id);
        return view('directions.show', compact('direction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $direction = Direction::findOrFail($id);
        return view('directions.edit', compact('direction'));
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
        $direction = Direction::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('occupations', 'name')->ignore($direction->id)],
            'acronym' => ['required', 'string'],
        ]);

        $input = $request->all();

        $direction->update([
            'name' => $input['name'],
            'acronym' => $input['acronym'],
        ]);

        $resp = [
            'message' => __('Diretoria Atualizada com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('directions.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $direction = Direction::findOrFail($id);

        $direction->delete();

        return response()->json([
            'message' => __('Diretoria Apagada com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter direction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $directions = Direction::filter($request->all());
        $directions = $directions->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('directions.filter-result', compact('directions', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $directions,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
