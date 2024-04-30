<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ConversationItem;
use App\Models\Customer;

class ReportController extends Controller
{

  /**
   * Gets conversation items list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report1(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date")) : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date")) : now();

    $conversations = ConversationItem::whereBetween("interaction_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('reports.report-1', compact('conversations', 'startDate', 'endDate'));

    $html = view('reports.report-1', compact('conversations', 'startDate', 'endDate'))->render();

    return response()->streamDownload(function () use ($html) {

      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = $reader->loadFromString($html);

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      $writer->save("php://output");
    }, "Relatório de Interações.xls");
  }

  /**
   * Gets customer list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report2(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date")) : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date")) : now();

    $customers = Customer::whereBetween("created_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('reports.report-2', compact('conversations', 'startDate', 'endDate'));

    $html = view('reports.report-2', compact('customers', 'startDate', 'endDate'))->render();

    return response()->streamDownload(function () use ($html) {

      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = $reader->loadFromString($html);

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      $writer->save("php://output");
    }, "Relatório de Clientes-Empresas.xls");
  }
}
