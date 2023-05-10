<?php

namespace App\Http\Controllers;

use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'conversation_item_id' => ['required', 'exists:conversation_items,id'],
            'description' => ['required', 'string', 'max:255'],
            'value_type' => ['required', 'string', 'in:proposed,others'],
            'obs' => ['nullable', 'string', 'max:255'],
            'value' => ['required', 'numeric']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $input = $request->all();

        $value = Value::create([
            'conversation_item_id' => $input['conversation_item_id'],
            'description' => $input['description'],
            'obs' => $input['obs'],
            'value_type' => $input['value_type'],
            'value' => $input['value'],
        ]);

        return response()->json([
            'message' => __('Valor Salvo com Sucesso!'),
            'alert-type' => 'success',
            'value' => view('conversations.item.value-content', compact('value'))->render()
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validation($request);

        $value = Value::findOrFail($id);

        $input = $request->all();

        $value->update([
            'conversation_item_id' => $input['conversation_item_id'],
            'description' => $input['description'],
            'obs' => $input['obs'],
            'value_type' => $input['value_type'],
            'value' => $input['value'],
        ]);

        return response()->json([
            'message' => __('Valor Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'value' => view('conversations.item.value-content', compact('value'))->render()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Value::findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => __('Valor Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }
}
