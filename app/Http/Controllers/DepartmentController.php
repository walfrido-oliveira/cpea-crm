<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Department;
use App\Models\Direction;

class DepartmentController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin')->only(['create', 'edit', 'destroy', 'store', 'update']);
    $this->middleware('role:admin|viewer')->only(['index', 'show']);
  }

  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $departments =  Department::filter($request->all());
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';
    $directions = Direction::pluck('name', 'id');

    return view('departments.index', compact('departments', 'ascending', 'orderBy', 'directions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $directions = Direction::pluck('name', 'id');
    return view('departments.create', compact('directions'));
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
      'name' => ['required', 'string', 'max:255', Rule::unique('departments', 'name')],
      'acronym' => ['required', 'string'],
      'direction_id' => ['required', 'exists:directions,id']
    ]);

    $input = $request->all();

    Department::create([
      'name' => $input['name'],
      'acronym' => $input['acronym'],
      'direction_id' => $input['direction_id'],
    ]);

    $resp = [
      'message' => __('Departamento Cadastrado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('departments.index')->with($resp);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $department = Department::findOrFail($id);
    return view('departments.show', compact('department'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $department = Department::findOrFail($id);
    $directions = Direction::pluck('name', 'id');
    return view('departments.edit', compact('department', 'directions'));
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
    $department = Department::findOrFail($id);

    $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('occupations', 'name')->ignore($department->id)],
      'acronym' => ['required', 'string'],
      'direction_id' => ['required', 'exists:directions,id']
    ]);

    $input = $request->all();

    $department->update([
      'name' => $input['name'],
      'acronym' => $input['acronym'],
      'direction_id' => $input['direction_id'],
    ]);

    $resp = [
      'message' => __('Departamento Atualizado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('departments.index')->with($resp);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $department = Department::findOrFail($id);

    $department->delete();

    return response()->json([
      'message' => __('Departamento Apagado com Sucesso!!'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Filter department
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $departments = Department::filter($request->all());
    $departments = $departments->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('departments.filter-result', compact('departments', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $departments,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
