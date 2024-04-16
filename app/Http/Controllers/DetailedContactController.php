<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DetailedContact;

class DetailedContactController extends Controller
{
    public function validation($request)
    {
        $request->validate([
            'contact' => ['required', 'string', 'max:255'],
            'mail' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable','string', 'max:255'],
            'cell_phone' => ['nullable','string', 'max:255'],
            'role' => ['nullable','string', 'max:255'],
            'linkedin' => ['nullable','string', 'max:255'],
            'secretary' => ['nullable','string', 'max:255'],
            'mail_secretary' => ['nullable','string', 'max:255'],
            'phone_secretary' => ['nullable','string', 'max:255'],
            'cell_phone_secretary' => ['nullable','string', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id']
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('detailed-contact.create');
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

       DetailedContact::create([
            'contact' => $input['contact'],
            'mail' => $input['mail'],
            'phone' => $input['phone'],
            'cell_phone' => $input['cell_phone'],
            'role' => $input['role'],
            'linkedin' => $input['linkedin'],
            'secretary' => $input['secretary'],
            'mail_secretary' => $input['mail_secretary'],
            'phone_secretary' => $input['phone_secretary'],
            'cell_phone_secretary' => $input['cell_phone_secretary'],
            'customer_id' => $input['customer_id'],
        ]);

        $resp = [
            'message' => __('Contato Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.show', ['customer' => $input['customer_id']])->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detailedContact = DetailedContact::findOrFail($id);
        return view('detailed-contact.show', compact('detailedContact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detailedContact = DetailedContact::findOrFail($id);
        return view('detailed-contact.edit', compact('detailedContact'));
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
        $detailedContact = DetailedContact::findOrFail($id);

        $this->validation($request);

        $input = $request->all();

        $detailedContact->update([
            'contact' => $input['contact'],
            'mail' => $input['mail'],
            'phone' => $input['phone'],
            'cell_phone' => $input['cell_phone'],
            'role' => $input['role'],
            'linkedin' => $input['linkedin'],
            'secretary' => $input['secretary'],
            'mail_secretary' => $input['mail_secretary'],
            'phone_secretary' => $input['phone_secretary'],
            'cell_phone_secretary' => $input['cell_phone_secretary'],
            'customer_id' => $input['customer_id'],
        ]);

        $resp = [
            'message' => __('Contato Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.show', ['customer' => $input['customer_id']])->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detailedContact = DetailedContact::findOrFail($id);

        $detailedContact->delete();

        return response()->json([
            'message' => __('Contato Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    public function getContactsByCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer->detailedContats);
    }
}
