<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use App\Models\Customer;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
    $customers =  Customer::filter($request->all(), true);
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';
    $status = Customer::getStatusArray();
    $segments = Segment::pluck("name", "id");

    return view('customers.companies.index', compact('customers', 'ascending', 'orderBy', 'status', 'segments'));
  }

  /**
   * Filter customer
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $customers = Customer::filter($request->all(), true);
    $customers = $customers->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('customers.companies.filter-result', compact('customers', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $customers,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
