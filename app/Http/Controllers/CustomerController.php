<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GeneralContactType;
use App\Models\Sector;
use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    public function validation($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:14'],
            'corporate_name' => ['required', 'string', 'max:255'],
            'obs' => ['nullable', 'string', 'max:255'],
            'competitors' => ['nullable', 'string', 'max:255'],
            'segment_id' => ['required', 'exists:segments,id'],
            'sector_id' => ['required', 'exists:sectors,id'],
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
        $customers =  Customer::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

        return view('customers.index', compact('customers', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = Segment::pluck("name", "id");
        $sectors = Sector::pluck("name", "id");
        $generalContactTypes = GeneralContactType::pluck("name", "id");

        return view('customers.create', compact("segments", "sectors", "generalContactTypes"));
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

        $customer = Customer::create([
            'name' => $input['name'],
            'cnpj' => $input['cnpj'],
            'corporate_name' => $input['corporate_name'],
            'obs' => $input['obs'],
            'competitors' => $input['competitors'],
            'segment_id' => $input['segment_id'],
            'sector_id' => $input['sector_id'],
        ]);

        if(isset($inputs["addresses"])) {
            foreach ($inputs["addresses"] as $address) {
                $customer->adresses()->create([
                    'cep' => $address['cep'],
                    'address' => $address['address'],
                    'number' => $address['number'],
                    'complement' => $address['complement'],
                    'district' => $address['district'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                ]);
            }
        }

        if(isset($inputs["contacts"])) {
            foreach ($inputs["contacts"] as $contact) {
                $customer->adresses()->create([
                    'general_contact_type_id' => $contact['general_contact_type_id'],
                    'description' => $contact['description'],
                    'obs' => $contact['obs'],
                ]);
            }
        }

        $resp = [
            'message' => __('Cliente Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $segments = Segment::pluck("name", "id");
        $sectors = Sector::pluck("name", "id");
        $generalContactTypes = GeneralContactType::pluck("name", "id");

        return view('customers.edit', compact('customer', 'segments', 'sectors', 'generalContactTypes'));
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
        $customer = Customer::findOrFail($id);

        $this->validation($request);

        $input = $request->all();

        $customer->update([
            'name' => $input['name'],
            'cnpj' => $input['cnpj'],
            'corporate_name' => $input['corporate_name'],
            'obs' => $input['obs'],
            'competitors' => $input['competitors'],
            'segment_id' => $input['segment_id'],
            'sector_id' => $input['sector_id'],
        ]);

        if(isset($customer->addresses[0]) && isset($inputs["addresses"])) {
            $address = $inputs["addresses"][0];

            $customer->addresses()[0]->update([
                'cep' => $address['cep'],
                'address' => $address['address'],
                'number' => $address['number'],
                'complement' => $address['complement'],
                'district' => $address['district'],
                'city' => $address['city'],
                'state' => $address['state'],
            ]);
        }

        $resp = [
            'message' => __('Cliente Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('customers.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => __('Cliente Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $customers = Customer::filter($request->all());
        $customers = $customers->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('customers.filter-result', compact('customers', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $customers,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }
}
