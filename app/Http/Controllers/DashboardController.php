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
    $items = $this->getItems($year);
    $itemsOld = $this->getItems($year - 1);
    $cumulative = $this->getCumulative($year);
    $goals = $this->getGoal($year);
    $sum = array_sum($items->toArray());
    $sumOld = array_sum($itemsOld->toArray());
    return view('dashboard', compact('items', 'year', 'sum', 'itemsOld',
    'directions', 'departments', 'years', 'sumOld', 'cumulative', 'goals'));
  }

  private function getItems($year)
  {
    return Value::select(
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
  }

  private function getCumulative($year, $department_id = null, $direction_id = null)
  {
    $cumulative = Value::from('values AS v1')
    ->select(
      DB::raw('sum(v1.value) as sums'),
      DB::raw("DATE_FORMAT(v1.created_at,'%M %Y') as months")
    )
    ->join('conversation_items', 'v1.conversation_item_id', '=', 'conversation_items.id')
    ->join('values AS v2', 'v1.created_at', '>=', 'v2.created_at')
    ->whereYear('v1.created_at', $year);

    if($department_id)
      $cumulative->where("conversation_items.department_id", $department_id);

    if($direction_id )
      $cumulative->where("conversation_items.direction_id", $direction_id );

    return $cumulative->groupBy('months')->pluck('sums');
  }

  private function getGoal($year, $department_id = null, $direction_id = null)
  {
    $goals = Goal::select('value', 'month')->where('year', $year);

    if($department_id)
      $goals->where("department_id", $department_id);

    if($direction_id)
      $goals->where("direction_id", $direction_id);

    return $goals->groupBy('month')->pluck('value');
  }

  public function filterChar01(Request $request)
  {
    $items = $this->getItems($request->get('year'));
    $itemsOld = $this->getItems($request->get('year') - 1);
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
    $items = $this->getItems($request->get('year'));
    $itemsOld = $this->getItems($request->get('year') - 1);
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
    $cumulative = $this->getCumulative($request->get('year'), $request->get('department_id'), $request->get('direction_id'));
    $goals =  $goals = $this->getGoal($request->get('year'), $request->get('department_id'), $request->get('direction_id'));

    return response()->json([
      'cumulative' => $cumulative,
      'goals' => $goals,
      'year' => $request->get('year')
    ]);
  }
}
