<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ConversationStatus;

class ConversationStatusController extends Controller
{
    /**
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conversationStatuss =  ConversationStatus::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';
        $types = ConversationStatus::getTypesAttribute();
        return view('conversation-statuss.index', compact('conversationStatuss', 'ascending', 'orderBy', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ConversationStatus::getTypesAttribute();
        return view('conversation-statuss.create', compact('types'));
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
            'name' => ['required', 'string', 'max:255', Rule::unique('conversation_statuses', 'name')],
            'type' => ['required', 'string'],
        ]);

        $input = $request->all();

       ConversationStatus::create([
            'name' => $input['name'],
            'type' => $input['type'],
        ]);

        $resp = [
            'message' => __('Status Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('conversation-statuss.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversationStatus = ConversationStatus::findOrFail($id);
        return view('conversation-statuss.show', compact('conversationStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conversationStatus = ConversationStatus::findOrFail($id);
        $types = ConversationStatus::getTypesAttribute();
        return view('conversation-statuss.edit', compact('conversationStatus', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $conversationStatus = ConversationStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('conversation_statuses', 'name')],
            'type' => ['required', 'string'],
        ]);

        $input = $request->all();

        $conversationStatus->update([
            'name' => $input['name'],
            'type' => $input['type'],
        ]);

        $resp = [
            'message' => __('Status Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('conversation-statuss.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conversationStatus = ConversationStatus::findOrFail($id);

        $conversationStatus->delete();

        return response()->json([
            'message' => __('Status Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter conversationStatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $conversationStatuss = ConversationStatus::filter($request->all());
        $conversationStatuss = $conversationStatuss->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('conversation-statuss.filter-result', compact('conversationStatuss', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $conversationStatuss,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
