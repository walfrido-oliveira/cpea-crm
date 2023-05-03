<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

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
}
