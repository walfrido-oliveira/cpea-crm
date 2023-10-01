<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConversationItem;

class CpeaIdController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conversationItems =  ConversationItem::filter($request->all(), true);
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('conversations.cpea-ids.index', compact('conversationItems', 'ascending', 'orderBy'));
    }

     /**
     * Filter customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $conversationItems =  ConversationItem::filter($request->all(), true);
        $conversationItems = $conversationItems->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('conversations.cpea-ids.filter-result', compact('conversationItems', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $conversationItems,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
            ])->render(),
        ]);
    }
}
