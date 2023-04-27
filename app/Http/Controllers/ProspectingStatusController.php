<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProspectingStatus;

class ProspectingStatusController extends Controller
{
     /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prospectingStatuss =  ProspectingStatus::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('prospecting-statuss.index', compact('prospectingStatuss', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prospecting-statuss.create');
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
            'name' => ['required', 'string', 'max:255', Rule::unique('contact_types', 'name')],
        ]);

        $input = $request->all();

        ProspectingStatus::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('prospecting-statuss.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prospectingStatus = ProspectingStatus::findOrFail($id);
        return view('prospecting-statuss.show', compact('prospectingStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prospectingStatus = ProspectingStatus::findOrFail($id);
        return view('prospecting-statuss.edit', compact('prospectingStatus'));
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
        $prospectingStatus = ProspectingStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('contact_types', 'name')->ignore($prospectingStatus->id)],
        ]);

        $input = $request->all();

        $prospectingStatus->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('prospecting-statuss.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prospectingStatus = ProspectingStatus::findOrFail($id);

        $prospectingStatus->delete();

        return response()->json([
            'message' => __('Status Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter prospectingStatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $prospectingStatuss = ProspectingStatus::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('prospecting-statuss.filter-result', compact('prospectingStatuss', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $prospectingStatuss,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
