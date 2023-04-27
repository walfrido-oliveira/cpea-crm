<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Occupation;
use App\Events\CreatedUser;
use App\Events\UpdatedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users =  User::filter($request->all());
        $roles = Role::all()->pluck('name', 'name');
        $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
        $orderBy = isset($query['order_by']) ? $query['order_by'] : 'id';

        return view('users.index', compact('users', 'roles', 'ascending', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =  Role::all()->pluck('name', 'name');
        $status = User::getStatusArray();
        $occupations  = Occupation::all()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');

        return view('users.create', compact('roles', 'status', 'occupations', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();

        $user = User::create([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'phone' => preg_replace('/[^0-9]/', '', $input['phone']),
            'email' => $input['email'],
            'status' => $input['status'],
            'password' => Hash::make(Str::random(8)),
            'crq' => $input['crq'],
            'department_id' => $input['department_id'],
            'occupation_id' => $input['occupation_id'],
        ]);

        if($request->signer) {
            $sigerName = time().'.'.$request->signer->getClientOriginalExtension();
            $request->signer->move(public_path(User::getSignerPath()), $sigerName);
            $signerPath = User::getSignerPath() . '/' . $sigerName;
            $user->signer = $signerPath;
            $user->save();
        }

        $user->syncRoles([$input['role']]);

        event(new CreatedUser($user));

        return redirect()->route('users.index')->with(defaultSaveMessagemNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name', 'name');
        $userRole = $user->roles->values()->get(0) ? $user->roles->values()->get(0)->name : null;

        $roles = $user->roles->pluck("name")->all();
        $rolesResult = [];
        foreach ($roles as $key => $value)
        {
            $rolesResult[ $key ] = __($value);
        }

        return view('users.show', compact('user', 'roles', 'userRole', 'rolesResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles =  Role::all()->pluck('name', 'name');
        $userRole = $user->roles->values()->get(0) ? $user->roles->values()->get(0)->name : null;
        $status = User::getStatusArray();
        $occupations  = Occupation::all()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');

        return view('users.edit', compact('user', 'roles', 'status', 'userRole', 'occupations', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $input = $request->all();

        $user = User::findOrFail($id);

        $user->update([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'phone' => preg_replace('/[^0-9]/', '', $input['phone']),
            'status' => $input['status'],
            'crq' => $input['crq'],
            'department_id' => $input['department_id'],
            'occupation_id' => $input['occupation_id'],
        ]);

        if($request->signer) {
            $sigerName = time().'.'.$request->signer->getClientOriginalExtension();
            $request->signer->move(public_path(User::getSignerPath()), $sigerName);
            $signerPath = User::getSignerPath() . '/' . $sigerName;
            $user->signer = $signerPath;
            $user->save();
        }

        $user->syncRoles([$input['role']]);

        //event(new UpdatedUser($user));

        return redirect()->route('users.show', ['user' => $user->id])->with(defaultSaveMessagemNotification());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Usuário Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Filter User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $users = User::filter($request->all());
        $users = $users->setPath('');
        $orderBy = $request->get('order_by');
        $ascending = $request->get('ascending');
        $paginatePerPage = $request->get('paginate_per_page');

        return response()->json([
        'filter_result' => view('users.filter-result', compact('users', 'orderBy', 'ascending'))->render(),
        'pagination' => view('layouts.pagination', [
            'models' => $users,
            'order_by' => $orderBy,
            'ascending' => $ascending,
            'paginate_per_page' => $paginatePerPage,
            ])->render(),
        ]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([Fortify::email() => 'required|email']);

        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );

        $notification = $status == Password::RESET_LINK_SENT
            ? array(
                'message' => 'Resete de senha enviado com sucesso!',
                'alert-type' => 'success'
            )
            : array(
                'message' => 'Ocorreu um erro ao enviar resete.',
                'alert-type' => 'error');

        return redirect()->back()->with($notification);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
