<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposedStatus;
use Illuminate\Validation\Rule;

class ProposedStatusController extends Controller
{
     /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $proposedStatuss =  ProposedStatus::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('proposed-statuss.index', compact('proposedStatuss', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proposed-statuss.create');
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

        ProposedStatus::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('proposed-statuss.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposedStatus = ProposedStatus::findOrFail($id);
        return view('proposed-statuss.show', compact('proposedStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposedStatus = ProposedStatus::findOrFail($id);
        return view('proposed-statuss.edit', compact('proposedStatus'));
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
        $proposedStatus = ProposedStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('contact_types', 'name')->ignore($proposedStatus->id)],
        ]);

        $input = $request->all();

        $proposedStatus->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('proposed-statuss.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proposedStatus = ProposedStatus::findOrFail($id);

        $proposedStatus->delete();

        return response()->json([
            'message' => __('Status Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter proposedStatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $proposedStatuss = ProposedStatus::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('proposed-statuss.filter-result', compact('proposedStatuss', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $proposedStatuss,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
