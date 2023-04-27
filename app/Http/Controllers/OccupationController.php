<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OccupationController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $occupations =  Occupation::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('occupations.index', compact('occupations', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('occupations.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('occupations', 'name')],
        ]);

        $input = $request->all();

       Occupation::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Cargo Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('occupations.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $occupation = Occupation::findOrFail($id);
        return view('occupations.show', compact('occupation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occupation = Occupation::findOrFail($id);
        return view('occupations.edit', compact('occupation'));
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
        $occupation = Occupation::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('occupations', 'name')->ignore($occupation->id)],
        ]);

        $input = $request->all();

        $occupation->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Cargo Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('occupations.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $occupation = Occupation::findOrFail($id);

        $occupation->delete();

        return response()->json([
            'message' => __('Cargo Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter occupation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $occupations = Occupation::filter($request->all());
        $occupations = $occupations->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('occupations.filter-result', compact('occupations', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $occupations,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
