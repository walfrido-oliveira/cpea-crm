<?php

namespace App\Http\Controllers;

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
    $year = 2024;
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

    $sum = array_sum($items->toArray());

    return view('dashboard', compact('items', 'year', 'sum', 'itemsOld', 'directions', 'departments', 'years'));
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
}
