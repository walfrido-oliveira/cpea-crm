<?php

namespace App\Http\Controllers;

use App\Models\DetailedContact;
use Illuminate\Http\Request;

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
    * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detailedContacts =  DetailedContact::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('detailed-contact.index', compact('detailedContacts', 'ascending', 'orderBy'));
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

        return redirect()->route('detailed-contact.index')->with($resp);
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

        return redirect()->route('detailed-contact.index')->with($resp);
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

    /**
     * Filter detailedContact
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $detailedContacts = DetailedContact::filter($request->all());
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('detailed-contact.filter-result', compact('detailedContacts', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $detailedContacts,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
