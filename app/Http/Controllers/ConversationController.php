<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Customer;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ConversationItem;

class ConversationController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $conversation = Conversation::findOrFail($id);
    return view('conversations.show', compact('conversation'));
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
      'customer_id' => ['required', 'string', 'exists:customers,id'],
    ]);

    $conversation = Conversation::create([
      'customer_id' => $request->get("customer_id")
    ]);

    $resp = [
      'message' => __('Conversa Cadastrada com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('customers.conversations.show', ['conversation' => $conversation->id])->with($resp);
  }

  public function getByCustomer($id)
  {
    $customer = Customer::findOrFail($id);
    return response()->json($customer->conversations);
  }

  public function getById($id)
  {
    $conversation = Conversation::findOrFail($id);
    return response()->json($conversation);
  }

  public function report1(Request $request)
  {
    $startDate = $request->has("start_date") ? new Carbon($request->get("start_date")) : now();
    $endDate = $request->has("end_date") ? new Carbon($request->get("end_date")) : now();

    $conversations = ConversationItem::whereBetween("interaction_at", [$startDate, $endDate])->get();

    if ($request->has("debug")) return view('conversations.reports.report-1', compact('conversations', 'startDate', 'endDate'));

    $html = view('conversations.reports.report-1', compact('conversations', 'startDate', 'endDate'))->render();

    return response()->streamDownload(function () use ($html) {

      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = $reader->loadFromString($html);

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      $writer->save("php://output");
    }, "Relatório de Interações.xls");
  }
}
