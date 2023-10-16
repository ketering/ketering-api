<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\User\StoreUserRequest;
use App\Http\Requests\AdminPanel\User\UpdateUserRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('users.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::where('id', '>', \Auth::user()->role_id)->get();
        return view('users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $input = $request->validated();
        $user = new User(\Arr::except($input, ['role_id']));
        $role = Role::findOrFail($input['role_id']);

        $role->users()->save($user);
        return redirect()->route('users.index')->with('success', 'User successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        $roles = Role::where('id', '>', \Auth::user()->role_id)->get();
        return view('users.show', [
            'user' => $user,
            'roles' => $roles,
            'companies' => Company::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        return redirect()->route('users.show', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $input = $request->validated();
        $user->update(\Arr::only($input, ['name', 'surname', 'email']));

        $role = Role::findOrFail($input['role_id']);
        $role->users()->save($user);

        $company = Company::findOrFail($input['company_id']);
        $company->users()->save($user);

        return redirect()->route('users.show', $user->id)->with('success', "{$user->role->name} uspješno ažuriran");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }
}
