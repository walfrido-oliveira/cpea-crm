<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Direction;
use App\Models\Department;
use App\Models\Occupation;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Validate form
     *
     *@param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validating(Request $request) {
        $request->validate([
            'occupation_id' => ['required', 'exists:occupations,id'],
            'direction_id' => ['required', 'exists:directions,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'manager_id' => ['required', 'exists:employees,id'],
            'employee_id' => ['required', 'string'],
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
        $employees =  Employee::filter($request->all());
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'employee_id';

        return view('employees.index', compact('employees', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $occupations  = Occupation::all()->pluck('name', 'id');
        $directions = Direction::all()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');
        $employees = Employee::all()->pluck('name', 'id');

        return view('employees.create', compact('occupations', 'directions', 'departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validating($request);

        $input = $request->all();

       Employee::create([
            'occupation_id' => $input['occupation_id'],
            'direction_id' => $input['direction_id'],
            'department_id' => $input['department_id'],
            'name' => $input['name'],
            'manager_id' => $input['manager_id'],
            'employee_id' => $input['employee_id'],
        ]);

        $resp = [
            'message' => __('Colaborador Cadastrado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('employees.index')->with($resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $occupations  = Occupation::all()->pluck('name', 'id');
        $directions = Direction::all()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');
        $employees = Employee::all()->pluck('name', 'id');

        return view('employees.edit', compact('employee', 'occupations', 'directions', 'departments', 'employees'));
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
        $department = Employee::findOrFail($id);

        $this->validating($request);

        $input = $request->all();

        $department->update([
            'occupation_id' => $input['occupation_id'],
            'direction_id' => $input['direction_id'],
            'department_id' => $input['department_id'],
            'name' => $input['name'],
            'manager_id' => $input['manager_id'],
            'employee_id' => $input['employee_id'],
        ]);

        $resp = [
            'message' => __('Colaborador Atualizado com Sucesso!'),
            'alert-type' => 'success'
        ];

        return redirect()->route('employees.index')->with($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Employee::findOrFail($id);

        $department->delete();

        return response()->json([
            'message' => __('Colaborador Apagado com Sucesso!!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter department
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $employees = Employee::filter($request->all());
        $employees = $employees->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
            'filter_result' => view('employees.filter-result', compact('employees', 'orderBy', 'ascending'))->render(),
            'pagination' => view('layouts.pagination', [
                'models' => $employees,
                'order_by' => $orderBy,
                'ascending' => $ascending,
                'paginate_per_page' => $paginatePerPage,
                ])->render(),
            ]);
    }

}
