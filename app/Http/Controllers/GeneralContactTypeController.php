<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\GeneralContactType;

class GeneralContactTypeController extends Controller
{
     /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $generalContactTypes =  GeneralContactType::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('general-contact-types.index', compact('generalContactTypes', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general-contact-types.create');
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

       GeneralContactType::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Contato Geral Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('general-contact-types.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $generalContactType = GeneralContactType::findOrFail($id);
        return view('general-contact-types.show', compact('generalContactType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $generalContactType = GeneralContactType::findOrFail($id);
        return view('general-contact-types.edit', compact('generalContactType'));
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
        $generalContactType = GeneralContactType::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('contact_types', 'name')->ignore($generalContactType->id)],
        ]);

        $input = $request->all();

        $generalContactType->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Tipo Contato Geral Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('general-contact-types.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $generalContactType = GeneralContactType::findOrFail($id);

        $generalContactType->delete();

        return response()->json([
            'message' => __('Tipo Contato Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter contactType
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $generalContactTypes = GeneralContactType::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('general-contact-types.filter-result', compact('contactTypes', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $generalContactTypes,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
