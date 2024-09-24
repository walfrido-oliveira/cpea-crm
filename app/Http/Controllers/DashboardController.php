<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Goal;
use App\Models\Value;
use App\Models\Direction;
use App\Models\Department;
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
    $years = [$year - 1 => $year - 1, $year => $year];
    $directions = Direction::pluck("name", "id");
    $departments = Department::pluck("name", "id");
    $items = $this->getItems($year, true);
    $itemsOld = $this->getItems($year - 1, true);
    $cumulative = $this->getCumulative($year);
    $goals = $this->getGoal($year);
    $sum = array_sum($items->toArray());
    $sumOld = array_sum($this->getItems($year - 1, true, null, null, true)->toArray());
    $sumTotalItems = array_sum($this->getItems($year)->toArray());
    return view('dashboard', compact('items', 'year', 'sum', 'itemsOld',
    'directions', 'departments', 'years', 'sumOld', 'cumulative', 'goals', 'sumTotalItems'));
  }

  private function getItems($year, $approved = false, $department_id = null, $direction_id = null, $partialyear = false)
  {
    $currentMonth = Carbon::now()->month;
    $currentDay = Carbon::now()->day;
    $startDate = Carbon::parse("$year-01-01");
    $endDate = Carbon::parse("$year-$currentMonth-$currentDay");

    $value = Value::select(
      DB::raw('sum(value) as sums'),
      DB::raw("DATE_FORMAT(interaction_at,'%M %Y') as months")
    )
    ->join('conversation_items', 'values.conversation_item_id', '=', 'conversation_items.id')
    ->where("item_type", "Proposta");

    if($partialyear) {
      $value = $value->whereBetween('interaction_at', [$startDate, $endDate]);
    } else {
      $value = $value->whereYear("interaction_at", $year);
    }

    $value = $value->whereHas('conversationItem', function ($q) use($approved, $department_id, $direction_id) {
      if($approved)
        $q->where("conversation_status_id", 14);

      if($department_id)
        $q->where("department_id", $department_id);

      if($direction_id )
        $q->where("direction_id", $direction_id );
    })
    ->groupBy('months')
    ->orderBy('conversation_items.interaction_at')
    ->pluck('sums');

    return $value;
  }

  private function getCumulative($year, $department_id = null, $direction_id = null)
  {
    $cumulative = Value::from('values AS s1')
    ->select(
      DB::raw("date_format(ci.interaction_at,'%b-%Y') as month"),
      DB::raw("(select sum(s2.value) from `values` s2 inner join conversation_items ci2 on ci2.id = s2.conversation_item_id where ci2.interaction_at <= last_day(ci.interaction_at)) as sums")
    )
    ->join('conversation_items AS ci', 'ci.id', '=', 's1.conversation_item_id')
    ->whereYear('ci.interaction_at', $year)
    ->where("ci.conversation_status_id", 14);

    if($department_id)
      $cumulative->where("ci.department_id", $department_id);

    if($direction_id )
      $cumulative->where("ci.direction_id", $direction_id );

    return $cumulative->groupBy('month')
    ->orderBy('ci.interaction_at')
    ->pluck('sums');
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
    $items = $this->getItems($request->get('year'), true, $request->get('department_id'), $request->get('direction_id'));
    $itemsOld = $this->getItems($request->get('year') - 1, true, $request->get('department_id'), $request->get('direction_id'));
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
    $items = $this->getItems($request->get('year'), true, $request->get('department_id'), $request->get('direction_id'));
    $itemsOld = $this->getItems($request->get('year') - 1, true, $request->get('department_id'), $request->get('direction_id'));
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

  public function filterChar04(Request $request)
  {
    $items = $this->getItems($request->get('year'), true, $request->get('department_id'), $request->get('direction_id'));
    $totalIems = $this->getItems($request->get('year'), false, $request->get('department_id'), $request->get('direction_id'));
    $sum = array_sum($items->toArray());
    $sumTotalItems = array_sum($totalIems->toArray());

    return response()->json([
      'sum' => $sum,
      'sumTotalItems' => $sumTotalItems,
      'year' => $request->get('year')
    ]);
  }
}
