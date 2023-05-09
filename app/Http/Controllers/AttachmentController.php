<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'conversation_item_id' => ['required', 'exists:conversation_items,id'],
            'name' => ['required', 'string', 'max:255'],
            'obs' => ['nullable', 'string', 'max:255'],
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

        $path = $request->file('file')->store('public/files');

        $attachment = Attachment::create([
            'conversation_item_id' => $input['conversation_item_id'],
            'name' => $input['name'],
            'obs' => $input['obs'],
            'path' => $path,
        ]);

        return response()->json([
            'message' => __('Arquivo Enviado com Sucesso!'),
            'alert-type' => 'success',
            'attachment' => view('conversations.item.attachment-content', compact('attachment'))->render()
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
        $customer = Attachment::findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => __('Anexo Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

}
