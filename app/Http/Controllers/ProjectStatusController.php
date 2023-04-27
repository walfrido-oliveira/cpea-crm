<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use Illuminate\Validation\Rule;

class ProjectStatusController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectStatuss =  ProjectStatus::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('project-statuss.index', compact('projectStatuss', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project-statuss.create');
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

        ProjectStatus::create([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project-statuss.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectStatus = ProjectStatus::findOrFail($id);
        return view('project-statuss.show', compact('projectStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectStatus = ProjectStatus::findOrFail($id);
        return view('project-statuss.edit', compact('projectStatus'));
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
        $projectStatus = ProjectStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('contact_types', 'name')->ignore($projectStatus->id)],
        ]);

        $input = $request->all();

        $projectStatus->update([
            'name' => $input['name'],
        ]);

        $resp = [
            'message' => __('Status Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('project-statuss.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectStatus = ProjectStatus::findOrFail($id);

        $projectStatus->delete();

        return response()->json([
            'message' => __('Status Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter projectStatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $projectStatuss = ProjectStatus::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('project-statuss.filter-result', compact('projectStatuss', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $projectStatuss,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
