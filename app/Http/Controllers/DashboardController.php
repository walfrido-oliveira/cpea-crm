<?php

namespace App\Http\Controllers;

use App\Models\Value;
use App\Models\Direction;
use App\Models\Department;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $year = now()->format('Y');
    $years = [2023 => 2023, 2024 => 2024];
    $directions = Direction::pluck("name", "id");
    $departments = Department::pluck("name", "id");
    $items = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
      ->whereHas('conversationItem', function ($q) {
        $q->where("item_type", "Proposta");
        //$q->where("conversation_status_id", 14);
      })
      ->whereYear('created_at', $year)
      ->groupBy('months')
      ->pluck('sums');

    $itemsOld = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
      ->whereHas('conversationItem', function ($q) {
        $q->where("item_type", "Proposta");
        //$q->where("conversation_status_id", 14);
      })
      ->whereYear('created_at', $year - 1)
      ->groupBy('months')
      ->pluck('sums');

    $cumulative = Value::from('values AS v1')
    ->select(
      DB::raw('sum(v1.value) as sums'),
      DB::raw("DATE_FORMAT(v1.created_at,'%M %Y') as months")
    )
    ->join('conversation_items', 'v1.conversation_item_id', '=', 'conversation_items.id')
    ->join('values AS v2', 'v1.created_at', '>=', 'v2.created_at')
    ->whereYear('v1.created_at', $year);

    if($request->has('department_id'))
      $cumulative->where("conversation_items.department_id", $request->get('department_id'));

    if($request->has('direction_id'))
      $cumulative->where("conversation_items.direction_id", $request->get('direction_id'));

    $cumulative = $cumulative->groupBy('months')->pluck('sums');

    $goals = Goal::select('value', 'month')
    ->where('year', $year);

    if($request->has('department_id'))
      $goals->where("department_id", $request->get('department_id'));

    if($request->has('direction_id'))
      $goals->where("direction_id", $request->get('direction_id'));

    $goals = $goals->groupBy('month')
    ->pluck('value');

    $sum = array_sum($items->toArray());
    $sumOld = array_sum($itemsOld->toArray());

    return view('dashboard', compact('items', 'year', 'sum', 'itemsOld',
    'directions', 'departments', 'years', 'sumOld', 'cumulative', 'goals'));
  }

  public function filterChar01(Request $request)
  {
    $items = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
    ->whereHas('conversationItem', function ($q) use($request) {
      $q->where("item_type", "Proposta");
      //$q->where("conversation_status_id", 14);
      if($request->has('department_id'))
        $q->where("department_id", $request->get('department_id'));

      if($request->has('direction_id'))
        $q->where("direction_id", $request->get('direction_id'));
    })
    ->whereYear('created_at', $request->get('year'))
    ->groupBy('months')
    ->pluck('sums');

    $itemsOld = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
    ->whereHas('conversationItem', function ($q) use($request) {
      $q->where("item_type", "Proposta");
      //$q->where("conversation_status_id", 14);
      if($request->has('department_id'))
        $q->where("department_id", $request->get('department_id'));

      if($request->has('direction_id'))
        $q->where("direction_id", $request->get('direction_id'));
    })
    ->whereYear('created_at', $request->get('year') - 1)
    ->groupBy('months')
    ->pluck('sums');

    $sum = array_sum($items->toArray());

    return response()->json([
      'items' => $items,
      'itemOlds' => $itemsOld,
      'sum' => $sum,
      'year' => $request->get('year')
    ]);
  }

  public function filterChar02(Request $request)
  {
    $items = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
    ->whereHas('conversationItem', function ($q) use($request) {
      $q->where("item_type", "Proposta");
      //$q->where("conversation_status_id", 14);
      if($request->has('department_id'))
        $q->where("department_id", $request->get('department_id'));

      if($request->has('direction_id'))
        $q->where("direction_id", $request->get('direction_id'));
    })
    ->whereYear('created_at', $request->get('year'))
    ->groupBy('months')
    ->pluck('sums');

    $itemsOld = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
    )
    ->whereHas('conversationItem', function ($q) use($request) {
      $q->where("item_type", "Proposta");
      //$q->where("conversation_status_id", 14);
      if($request->has('department_id'))
        $q->where("department_id", $request->get('department_id'));

      if($request->has('direction_id'))
        $q->where("direction_id", $request->get('direction_id'));
    })
    ->whereYear('created_at', $request->get('year') - 1)
    ->groupBy('months')
    ->pluck('sums');


    $sum = array_sum($items->toArray());
    $sumOld = array_sum($itemsOld->toArray());

    return response()->json([
      'sum' => $sum,
      'sumOld' => $sumOld,
      'year' => $request->get('year')
    ]);
  }

  public function filterChar03(Request $request)
  {
    $cumulative = Value::from('values AS v1')
    ->select(
      DB::raw('sum(v1.value) as sums'),
      DB::raw("DATE_FORMAT(v1.created_at,'%M %Y') as months")
    )
    ->join('conversation_items', 'v1.conversation_item_id', '=', 'conversation_items.id')
    ->join('values AS v2', 'v1.created_at', '>=', 'v2.created_at')
    ->whereYear('v1.created_at', $request->get('year'));

    if($request->has('department_id'))
      $cumulative->where("conversation_items.department_id", $request->get('department_id'));

    if($request->has('direction_id'))
      $cumulative->where("conversation_items.direction_id", $request->get('direction_id'));

    $cumulative = $cumulative->groupBy('months')->pluck('sums');

    $goals = Goal::select('value', 'month')
    ->where('year', $request->get('year'));

    if($request->has('department_id'))
      $goals->where("department_id", $request->get('department_id'));

    if($request->has('direction_id'))
      $goals->where("direction_id", $request->get('direction_id'));

    $goals = $goals->groupBy('month')
    ->pluck('value');

    return response()->json([
      'cumulative' => $cumulative,
      'goals' => $goals,
      'year' => $request->get('year')
    ]);
  }
}
