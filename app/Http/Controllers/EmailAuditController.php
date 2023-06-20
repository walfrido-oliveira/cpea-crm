<?php

namespace App\Http\Controllers;

use App\Models\EmailAudit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmailAuditController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $emailAudit =  EmailAudit::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('email-audit.index', compact('emailAudit', 'ascending', 'orderBy'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emailAudit = EmailAudit::findOrFail($id);
        return view('email-audit.show', compact('emailAudit'));
    }

    public function body($id)
    {
        $emailAudit = EmailAudit::findOrFail($id);
        $body = $emailAudit->body;
        $body = Str::replace("<br>", "", $body);
        return view('email-audit.body', compact('body'));
    }

    /**
     * Filter direction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $emailAudit = EmailAudit::filter($request->all());
        $emailAudit = $emailAudit->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('email-audit.filter-result', compact('emailAudit', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $emailAudit,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
