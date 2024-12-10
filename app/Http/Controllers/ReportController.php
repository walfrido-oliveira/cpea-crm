<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DetailedContact;
use App\Models\ConversationItem;
use Illuminate\Support\Facades\DB;

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
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 00:00:00') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $conversations = ConversationItem::whereBetween("interaction_at", [$startDate, $endDate])->orderBy('conversation_id')->get();

    if ($request->has("debug")) return view('reports.report-1', compact('conversations', 'startDate', 'endDate'));

    $html = view('reports.report-1', compact('conversations', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório de Interações.xls");
  }

  /**
   * Gets customer list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report2(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 00:00:00') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $customers = Customer::whereBetween("created_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('reports.report-2', compact('customers', 'startDate', 'endDate'));

    $html = view('reports.report-2', compact('customers', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório de Clientes-Empresas.xls");
  }

  /**
   * Gets contacts list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report3(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 00:00:00') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $contacts = Contact::whereBetween("created_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('reports.report-3', compact('contacts', 'startDate', 'endDate'));

    $html = view('reports.report-3', compact('contacts', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório Contatos Gerais do Cliente-Empresa.xls");
  }

  /**
   * Gets general contacts list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report4(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 23:59:59') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $contacts = DetailedContact::whereBetween("created_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('reports.report-4', compact('contacts', 'startDate', 'endDate'));

    $html = view('reports.report-4', compact('contacts', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório Contatos Gerais do Cliente-Empresa.xls");
  }

  /**
   * Gets conversation items list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report5(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 00:00:00') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $conversations1 = ConversationItem::whereBetween("interaction_at", [$startDate, $endDate])
      ->where('item_type', 'Proposta')
      ->whereHas("values", function ($q) {
        $q->where("additional_value", true);
      })
      ->orderBy('conversation_id')
      ->get();

    $subQuery = ConversationItem::select('id', DB::raw('MAX(interaction_at) AS max_data'))
      ->whereHas("values", function ($q) {
        $q->where("additional_value", false);
      })
      ->groupBy('conversation_id');

    $conversations2 = ConversationItem::from('conversation_items as t1')
      ->joinSub($subQuery, 't2', function ($join) {
        $join->on('t1.id', '=', 't2.id')->on('t1.interaction_at', '=', 't2.max_data');
      })
      ->whereBetween('t1.interaction_at', [$startDate, $endDate])
      ->where('item_type', 'Proposta')
      ->get();


    $conversations = $conversations1->merge($conversations2)->unique('id');

    $conversations = $conversations->sortBy('conversation_id')->values();

    if ($request->has("debug")) return view('reports.report-5', compact('conversations', 'startDate', 'endDate'));

    $html = view('reports.report-5', compact('conversations', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório de Interações.xls");
  }

  /**
   * Gets conversation items list in XLS format
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function report6(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date") . ' 00:00:00') : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date") . ' 23:59:59') : now();

    $subQuery = ConversationItem::select('conversation_id', DB::raw('MAX(interaction_at) AS max_data'))
      ->groupBy('conversation_id');

    $conversations = ConversationItem::from('conversation_items as t1')
      ->joinSub($subQuery, 't2', function ($join) {
        $join->on('t1.conversation_id', '=', 't2.conversation_id')
          ->on('t1.interaction_at', '=', 't2.max_data');
      })
      ->whereBetween('t1.interaction_at', [$startDate, $endDate])
      ->where('item_type', 'Proposta')
      ->get();

    if ($request->has("debug")) return view('reports.report-5', compact('conversations', 'startDate', 'endDate'));

    $html = view('reports.report-5', compact('conversations', 'startDate', 'endDate'))->render();

    return $this->reportFactory($html, "Relatório de Interações.xls");
  }

  private function reportFactory($html, $reportName)
  {
    return response()->streamDownload(function () use ($html) {

      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = $reader->loadFromString($html);

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      $writer->save("php://output");
    }, $reportName);
  }
}
