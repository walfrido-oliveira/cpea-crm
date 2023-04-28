<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
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

        $contact = Contact::create([
            'general_contact_type_id' => $input['general_contact_type_id'],
            'description' => $input['description'],
            'obs' => $input['obs'],
            'customer_id' => $input['customer_id'],
        ]);

        return response()->json([
            'message' => __('Contato Cadastrado com Sucesso!'),
            'alert-type' => 'success',
            'contact' => $contact
        ]);
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
        $contact = Contact::findOrFail($id);

        $this->validation($request);

        $input = $request->all();

        $contact->update([
            'general_contact_type_id' => $input['general_contact_type_id'],
            'description' => $input['description'],
            'obs' => $input['obs'],
        ]);

        return response()->json([
            'message' => __('Contato atualizado com Sucesso!!'),
            'alert-type' => 'success'
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
        $customer = Contact::findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => __('Contato Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }
}
