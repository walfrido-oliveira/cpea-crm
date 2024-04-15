<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\GeneralContactType;
use App\Models\Segment;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function validation($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:18'],
            'corporate_name' => ['required', 'string', 'max:255'],
            'obs' => ['nullable', 'string', 'max:255'],
            'competitors' => ['nullable', 'string', 'max:255'],
            'segment_id' => ['required', 'exists:segments,id'],
            'status' => ['in:active,inactive', 'nullable'],
            'customer_id' => ['nullable', 'exists:customers,id']
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
        $customers =  Customer::filter(['status' => 'active']);
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';
        $status = Customer::getStatusArray();
        $segments = Segment::pluck("name", "id");
        $isNewCustomer = ["" => "", true => "Sim", false => "Não"];

        return view('customers.index', compact('customers', 'ascending', 'orderBy', 'status', 'segments', 'isNewCustomer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = Segment::pluck("name", "id");
        $generalContactTypes = GeneralContactType::pluck("name", "id");
        $customers =  Customer::where("status", "active")->get()->pluck("name", "id");

        return view('customers.create', compact("segments", "generalContactTypes", "customers"));
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
            'cnpj' => preg_replace('/[^0-9]/', '', $input['cnpj']),
            'corporate_name' => $input['corporate_name'],
            'obs' => $input['obs'],
            'competitors' => $input['competitors'],
            'segment_id' => $input['segment_id'],
            'created_user_id' => auth()->user()->id,
            'customer_id' => $input['customer_id'],
        ]);

        if(isset($input["addresses"])) {
            foreach ($input["addresses"] as $address) {
                Address::create([
                    'cep' => preg_replace('/[^0-9]/', '', $address['cep']),
                    'address' => $address['address'],
                    'number' => $address['number'],
                    'complement' => $address['complement'],
                    'district' => $address['district'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'customer_id' => $customer->id,
                ]);
            }
        }

        if(isset($input["contacts"])) {
            foreach ($input["contacts"] as $contact) {
                Contact::create([
                    'general_contact_type_id' => $contact['general_contact_type_id'],
                    'description' => $contact['description'],
                    'obs' => $contact['obs'],
                    'customer_id' => $customer->id,
                ]);
            }
        }

        $resp = [
            'message' => __(($input['customer_id'] ? "Empresa Cadastrada " : "Cliente Cadastrado") . ' com Sucesso!'),
            'alert-type' => 'success'
        ];

        if($input['customer_id']) {
            return redirect()->to(route('customers.show', ['customer' => $input['customer_id']]) . "#empresas")->with($resp);
        } else {
            return redirect()->route('customers.edit', ['customer' => $customer->id])->with($resp);
        }

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
        $generalContactTypes = GeneralContactType::pluck("name", "id");
        $status = Customer::getStatusArray();
        $customers =  Customer::where("status", "active")->get()->pluck("name", "id");

        return view('customers.edit', compact('customer', 'segments', 'generalContactTypes', 'status', 'customers'));
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
            'cnpj' => preg_replace('/[^0-9]/', '', $input['cnpj']),
            'corporate_name' => $input['corporate_name'],
            'obs' => $input['obs'],
            'competitors' => $input['competitors'],
            'segment_id' => $input['segment_id'],
            'status' => $input['status'],
            'updated_user_id' => auth()->user()->id,
            'customer_id' => $input['customer_id'],
        ]);

        if(isset($customer->addresses[0]) && isset($inputs["addresses"])) {
            $address = $inputs["addresses"][0];

            $customer->addresses()[0]->update([
                'cep' => preg_replace('/[^0-9]/', '', $address['cep']),
                'address' => $address['address'],
                'number' => $address['number'],
                'complement' => $address['complement'],
                'district' => $address['district'],
                'city' => $address['city'],
                'state' => $address['state'],
            ]);
        }

        $resp = [
            'message' => __(($input['customer_id'] ? "Empresa Atulizada " : "Cliente Atulizado") . ' com Sucesso!'),
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
            'message' => __(($customer->customer_id ? "Empresa Apagada " : "Cliente Apagado") .' com Sucesso!!'),
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

    public function cnpj($cnpj)
    {
        $results = file_get_contents("https://www.receitaws.com.br/v1/cnpj/" . $cnpj);

        return response()->json(json_decode($results));
    }
}
