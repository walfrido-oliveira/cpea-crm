<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin')->only(['destroy', 'store', 'update']);
    $this->middleware('role:admin|viewer')->only(['show']);
  }

  public function validation($request)
  {
    $request->validate([
      'general_contact_type_id' => ['required', 'exists:general_contact_types,id'],
      'description' => ['required', 'string', 'max:255'],
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

    $contact = Contact::create([
      'general_contact_type_id' => $input['general_contact_type_id'],
      'description' => $input['description'],
      'obs' => $input['obs'],
      'customer_id' => $input['customer_id'],
    ]);

    $key = count(Customer::find($input['customer_id'])->contacts) - 1;

    return response()->json([
      'message' => __('Contato Cadastrado com Sucesso!'),
      'alert-type' => 'success',
      'contact' => view('customers.contact-content', compact('contact', 'key'))->render()
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
    $key = $input["key"];

    $contact->update([
      'general_contact_type_id' => $input['general_contact_type_id'],
      'description' => $input['description'],
      'obs' => $input['obs'],
    ]);

    return response()->json([
      'message' => __('Contato atualizado com Sucesso!!'),
      'alert-type' => 'success',
      'contact' => view('customers.contact-content', compact('contact', 'key'))->render()
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
