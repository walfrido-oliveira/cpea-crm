<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Direction;
use App\Models\Department;
use Illuminate\Http\Request;

class GoalController extends Controller
{

  public function validation($request)
  {
    $request->validate(
      [
        'direction_id' => ['required', 'exists:directions,id'],
        'department_id' => ['required', 'exists:departments,id'],
        'year' => ['required', 'numeric'],
        'month' => ['required', 'numeric'],
        'value' => ['required', 'numeric']
      ]
    );
  }

  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $goals =  Goal::filter($request->all());
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'year';
    $directions = Direction::pluck("name", "id");
    $departments = Department::pluck("name", "id");

    return view('goals.index', compact('goals', 'ascending', 'orderBy', 'directions', 'departments'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $directions = Direction::pluck("name", "id");
    $departments = Department::pluck("name", "id");
    return view('goals.create', compact('directions', 'departments'));
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

    Goal::create([
      'direction_id' => $input['direction_id'],
      'department_id' => $input['department_id'],
      'year' => $input['year'],
      'month' => $input['month'],
      'value' => $input['value'],
    ]);

    $resp = [
      'message' => __('Meta Cadastrada com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('config.goals.index')->with($resp);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $Goal = Goal::findOrFail($id);
    return view('goals.show', compact('Goal'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $goal = Goal::findOrFail($id);
    $directions = Direction::pluck("name", "id");
    $departments = Department::pluck("name", "id");
    return view('goals.edit', compact('goal', 'directions', 'departments'));
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
    $Goal = Goal::findOrFail($id);

    $this->validation($request);

    $input = $request->all();

    $Goal->update([
      'direction_id' => $input['direction_id'],
      'department_id' => $input['department_id'],
      'year' => $input['year'],
      'month' => $input['month'],
      'value' => $input['value'],
    ]);

    $resp = [
      'message' => __('Meta Atualizada com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('config.goals.index')->with($resp);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $Goal = Goal::findOrFail($id);

    $Goal->delete();

    return response()->json([
      'message' => __('Meta Apagada com Sucesso!!'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Filter Goal
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $goals = Goal::filter($request->all());
    $goals = $goals->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('goals.filter-result', compact('goals', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $goals,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
