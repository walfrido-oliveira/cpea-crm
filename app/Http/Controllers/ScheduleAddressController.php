<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleAddress;

class ScheduleAddressController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'conversation_item_id' => ['required', 'exists:conversation_items,id'],
            'address_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'obs' => ['nullable', 'string']
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

        $address = ScheduleAddress::create([
            'conversation_item_id' => $input['conversation_item_id'],
            'address_name' => $input['address_name'],
            'obs' => $input['obs'],
            'address' => $input['address'],
        ]);

        return response()->json([
            'message' => __('Destinatário Salvo com Sucesso!'),
            'alert-type' => 'success',
            'address' => view('conversations.item.address-content', compact('address'))->render()
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

        $address = ScheduleAddress::findOrFail($id);

        $input = $request->all();

        $address->update([
            'conversation_item_id' => $input['conversation_item_id'],
            'address_name' => $input['address_name'],
            'obs' => $input['obs'],
            'address' => $input['address'],
        ]);

        return response()->json([
            'message' => __('Destinatário Atualizado com Sucesso!'),
            'alert-type' => 'success',
            'address' => view('conversations.item.address-content', compact('address'))->render()
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
        $address = ScheduleAddress::findOrFail($id);

        $address->delete();

        return response()->json([
            'message' => __('Destinatário Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }
}
